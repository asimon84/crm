<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Portal\Permissions\Permissions;
use App\Portal\CreditCards\CardAssociations;
use App\Portal\Helpers\UploadFormats\OrdersUploadFormats;
use App\Portal\Clients\Clients;
use App\Portal\Orders\OrdersFields;
use App\Portal\Products\Products;
use App\Portal\MIDs\MIDs;
use App\Portal\Currencies\Currencies;
use Illuminate\Support\Facades\DB;
use App\Portal\Helpers\Traits\AddRecord;
use App\Portal\Helpers\Traits\ViewRecord;
use App\Portal\Helpers\Traits\EditRecord;
use App\Portal\Helpers\Traits\DeleteRecord;
use App\Portal\Helpers\Traits\UploadCSV;
use App\Portal\Helpers\Traits\CSVMapperFormats;
use App\Portal\Helpers\SQL\SQLHelper;

/**
 * Class OrdersAdminController
 *
 * This is the controller for the Orders Administration page of the application.  This class contains the methods to
 * load the view for the page, the methods to load any table and/or chart data required, and to attach any traits this
 * page will contain.
 *
 * @package App\Http\Controllers
 */
class OrdersAdminController extends Controller
{
    use ViewRecord;
    use AddRecord;
    use EditRecord;
    use DeleteRecord;
    use UploadCSV;
    use CSVMapperFormats;

    /**
     * @var string
     */
    public $view = 'orders-admin';

    /**
     * @var string
     */
    protected $module = 'orders';

    /**
     * @var array
     */
    protected $permissions = [];

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $editable_fields = [];

    /**
     * @var array
     */
    protected $clientsTableColumns = [
        'c.id',
        'c.name',
    ];

    /**
     * @var array
     */
    protected $ordersTableColumns = [
        'o.id',
        'c.name',
        'm.mid',
        'o.order_id',
        'o.arn',
        'o.card_number',
        'o.product_id',
        'o.transaction_date',
    ];

    /**
     * Create a new controller instance.
     *
     * Set any values used by the view or included traits here.  As of Laravel 5.3, Controllers are constructed before
     * the session is set, so anything that requires the session, such as the Auth class, cannot be called within the
     * Controller constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->fields = OrdersFields::getFields();
        $this->editable_fields = OrdersFields::getEditableFields();
        $this->record_class = '\App\Portal\Orders\Orders';
        $this->field_class = '\App\Portal\Orders\OrdersFields';
        $this->format_class = '\App\Portal\Helpers\UploadFormats\OrdersUploadFormats';
        $this->history_class = '\App\Portal\Orders\OrdersHistory';
        $this->identifier_field = 'order_id';
        $this->history_id = 'order_id';
        $this->view_record_title = 'View Order';
        $this->add_record_title = 'Add Order';
        $this->edit_record_title = 'Edit Order';
        $this->delete_record_title = 'Delete Order';
        $this->upload_csv_title = 'Upload Orders';
    }

    /**
     * Show the Orders Admin Page
     *
     * This method returns the view for the Orders Administration page.  All variables used within the view must be
     * included here.  Anything requiring Authentication must be done here as it cannot be done in the constructor as
     * of Laravel 5.3
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->permissions = [(new Permissions)->getOrdersPermissions(Auth::id())[0]];

        return view($this->view, [
            'module' => $this->module,
            'permissions' => $this->permissions,
            'record_fields' => $this->fields,
            'editable_fields' => $this->editable_fields,
            'view_record_title' => $this->view_record_title,
            'add_record_title' => $this->add_record_title,
            'edit_record_title' => $this->edit_record_title,
            'delete_record_title' => $this->delete_record_title,
            'upload_csv_title' => $this->upload_csv_title,
            'formats' => OrdersUploadFormats::all(),
            'card_associations' => CardAssociations::all(),
            'clients' => Clients::all(),
            'products' => Products::all(),
            'mids' => MIDs::all(),
            'currencies' => Currencies::all(),
            'response' => $request->old('response'),
        ]);
    }

    /**
     * Return data for Clients DataTable on Orders Admin Panel
     *
     * This method returns the JSON encoded data required by the Clients Alert Overview table on the Orders
     * Administration page.  This shows each individual order and their total orders and whether they are active or not.
     *
     * @param Request $request
     * @return string
     */
    public function ClientsTable(Request $request) :string
    {
        $vals = [];

        $draw = ($request->input('draw') !== null) ? $request->input('draw') : 0;
        $length = $request->input('length');
        $start = $request->input('start');
        $order = $request->input('order');
        $search = $request->input('search');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $limit_string = SQLHelper::getLimitString($start, $length);

        $order_string = SQLHelper::getOrderString($this->clientsTableColumns, $order, 'c.id');

        $date_string = '';
        if ($start_date != null && $end_date != null) {
            $date_string = SQLHelper::getDateRangeString('o.transaction_date', $start_date, $end_date);

            $vals['start_date'] = $start_date;
            $vals['end_date'] = $end_date;
        }

        $search_string = '';
        if (isset($search['value']) && $search['value'] != '') {
            $search_string = ' AND ( ';

            foreach($this->clientsTableColumns as $column) {
                $name = explode( '.', $column );
                $name = end($name);

                $search_string .= ' ' . $column . ' like :' . $name . ' OR ';

                $vals[$name] = "%" . $search['value'] . "%";
            }

            $search_string = substr($search_string, 0, -3);

            $search_string .= ' ) ';
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS ' . implode( ', ', $this->clientsTableColumns ) . ',
          (SELECT count(*) FROM orders o WHERE o.client_id = c.id ' . $date_string . ' AND o.active = 1 AND o.deleted_at IS NULL) as orders_count
          FROM clients c
          WHERE c.deleted_at IS NULL ' . $search_string . $order_string . $limit_string;

        $results = DB::select(DB::raw($sql), $vals);

        $clients = [];

        foreach ($results as $result) {
            $view_button = '<a href="#tab2" data-toggle="tab" class="btn btn-info" id="view_client_button" data-client_id="' . $result->id . '" title="View Client"><span class="fa fa-eye"></span></a>';
            $buttons = $view_button;

            $clients[] = [
                $result->id,
                $result->name,
                $result->orders_count,
                $buttons,
            ];
        }

        $sql = 'SELECT FOUND_ROWS() as count';

        $total = DB::select(DB::raw($sql));
        $total = isset($total[0]->count) ? $total[0]->count : 0;

        return json_encode(
            [
                'success' => true,
                'msg' => '',
                'draw' => $draw,
                'recordsTotal' => count($clients),
                'recordsFiltered' => $total,
                'data' => $clients
            ]
        );
    }

    /**
     * Return data for Orders DataTable on Orders Admin Panel
     *
     * This method returns the JSON encoded data required by the main Orders Administration table on the Orders
     * Administration page.  This will show the Order itself, with interactivity to view the complete set of Order
     * information, as well as the editing, and deleting of an Order (if the authenticated user has the
     * required permissions).
     *
     * @param Request $request
     * @return string
     */
    public function OrdersTable(Request $request) :string
    {
        $vals = [];

        $draw = ($request->input('draw') !== null) ? $request->input('draw') : 0;
        $length = $request->input('length');
        $start = $request->input('start');
        $order = $request->input('order');
        $search = $request->input('search');
        $client_id = ($request->input('client_id') !== null && $request->input('client_id') != 0) ? $request->input('client_id') : null;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $limit_string = SQLHelper::getLimitString($start, $length);

        $order_string = SQLHelper::getOrderString($this->ordersTableColumns, $order, 'c.id');

        $date_string = '';
        if ($start_date != null && $end_date != null) {
            $date_string = SQLHelper::getDateRangeString('o.transaction_date', $start_date, $end_date);

            $vals['start_date'] = $start_date;
            $vals['end_date'] = $end_date;
        }

        $search_string = '';
        if (isset($search['value']) && $search['value'] != '') {
            $search_string = ' AND ( ';

            foreach($this->ordersTableColumns as $column) {
                $name = explode( '.', $column );
                $name = end($name);

                $search_string .= ' ' . $column . ' like :' . $name . ' OR ';

                $vals[$name] = "%" . $search['value'] . "%";
            }

            $search_string = substr($search_string, 0, -3);

            $search_string .= ' ) ';
        }

        if( !is_null( $client_id ) && $client_id != 0 ) {
            $search_string .= ' AND o.client_id = :client_id ';
            $vals['client_id'] = $client_id;
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS p.name as product_name, o.client_id, ' . implode( ', ', $this->ordersTableColumns ) . '
          FROM orders o
          JOIN clients c ON c.id = o.client_id
          JOIN mids m ON m.id = o.mid_id
          JOIN products p ON o.product_id = p.id
          WHERE o.deleted_at IS NULL ' . $date_string . $search_string . $order_string . $limit_string;

        $results = DB::select(DB::raw($sql), $vals);

        $orders = [];

        foreach ($results as $result) {
            $view_button = '<button class="btn btn-info" id="view_record_button" data-id="' . $result->id . '" title="' . $this->view_record_title . '"><span class="fa fa-eye"></span></button>';
            $edit_button = '<button class="btn btn-success" id="edit_record_button" data-id="' . $result->id . '" title="' . $this->edit_record_title . '"><span class="fa fa-pencil"></span></button>';
            $delete_button = '<button class="btn btn-danger" id="delete_record_button" data-id="' . $result->id . '" title="' . $this->delete_record_title . '"><span class="fa fa-trash-o"></span></button>';
            $buttons = $view_button . $edit_button . $delete_button;

            $orders[] = [
                $result->id,
                $result->name,
                $result->mid,
                $result->order_id,
                $result->arn,
                $result->card_number,
                $result->product_name,
                $result->transaction_date,
                $buttons,
            ];
        }

        $sql = 'SELECT FOUND_ROWS() as count';

        $total = DB::select(DB::raw($sql));
        $total = isset($total[0]->count) ? $total[0]->count : 0;

        return json_encode(
            [
                'success' => true,
                'msg' => '',
                'draw' => $draw,
                'recordsTotal' => count($orders),
                'recordsFiltered' => $total,
                'data' => $orders
            ]
        );
    }
}