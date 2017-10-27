<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Portal\Permissions\Permissions;
use App\Portal\Clients\Clients;
use App\Portal\Products\ProductsFields;
use App\Portal\Products\ProductTypes;
use Illuminate\Support\Facades\DB;
use App\Portal\Helpers\Traits\AddRecord;
use App\Portal\Helpers\Traits\ViewRecord;
use App\Portal\Helpers\Traits\EditRecord;
use App\Portal\Helpers\Traits\DeleteRecord;
use App\Portal\Helpers\SQL\SQLHelper;

/**
 * Class ProductsAdminController
 *
 * This is the controller for the MIDs Administration page of the application.  This class contains the methods to
 * load the view for the page, the methods to load any table and/or chart data required, and to attach any traits this
 * page will contain.
 *
 * @package App\Http\Controllers
 */
class ProductsAdminController extends Controller
{
    use ViewRecord;
    use AddRecord;
    use EditRecord;
    use DeleteRecord;

    /**
     * @var string
     */
    public $view = 'products-admin';

    /**
     * @var string
     */
    protected $module = 'products';

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
    protected $clientProductsTableColumns = [
        'c.id',
        'c.name',
    ];

    /**
     * @var array
     */
    protected $productsTableColumns = [
        'p.id',
        'c.name',
        'p.name',
        't.name',
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

        $this->fields = ProductsFields::getFields();
        $this->editable_fields = ProductsFields::getEditableFields();
        $this->record_class = '\App\Portal\Products\Products';
        $this->field_class = '\App\Portal\Products\ProductsFields';
        $this->history_class = '\App\Portal\Products\ProductsHistory';
        $this->identifier_field = 'name';
        $this->history_id = 'product_id';
        $this->view_record_title = 'View Product';
        $this->add_record_title = 'Add Product';
        $this->edit_record_title = 'Edit Product';
        $this->delete_record_title = 'Delete Product';
    }

    /**
     * Show the Products Admin Page
     *
     * This method returns the view for the Products Administration page.  All variables used within the view must be
     * included here.  Anything requiring Authentication must be done here as it cannot be done in the constructor as
     * of Laravel 5.3
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->permissions = [(new Permissions)->getProductsPermissions(Auth::id())[0]];

        return view($this->view, [
            'module' => $this->module,
            'permissions' => $this->permissions,
            'record_fields' => $this->fields,
            'editable_fields' => $this->editable_fields,
            'view_record_title' => $this->view_record_title,
            'add_record_title' => $this->add_record_title,
            'edit_record_title' => $this->edit_record_title,
            'delete_record_title' => $this->delete_record_title,
            'clients' => Clients::all(),
            'product_types' => ProductTypes::all(),
            'response' => $request->old('response'),
        ]);
    }

    /**
     * Return data for Clients DataTable on Products Admin Panel
     *
     * This method returns the JSON encoded data required by the Clients Alert Overview table on the Products
     * Administration page.  This shows each individual Client and their total Products.
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

        $limit_string = SQLHelper::getLimitString($start, $length);

        $order_string = SQLHelper::getOrderString($this->clientProductsTableColumns, $order, $this->clientProductsTableColumns[0]);

        $search_string = '';
        if (isset($search['value']) && $search['value'] != '') {
            $search_string = ' AND ( ';

            foreach($this->clientProductsTableColumns as $column) {
                $name = explode( '.', $column );
                $name = end($name);

                $search_string .= ' ' . $column . ' like :' . $name . ' OR ';

                $vals[$name] = "%" . $search['value'] . "%";
            }

            $search_string = substr($search_string, 0, -3);

            $search_string .= ' ) ';
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS ' . implode(',', $this->clientProductsTableColumns) . ', (SELECT count(*) FROM products p WHERE p.client_id = c.id AND p.deleted_at IS NULL) as products_count
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
                $result->products_count,
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
     * Return data for Products DataTable on Products Admin Panel
     *
     * This method returns the JSON encoded data required by the main Products Administration table on the Products
     * Administration page.  This will show the Product itself, with interactivity to view the complete set of Product
     * information, as well as the editing, and activating/deactivating of a Product (if the authenticated user has the
     * required permissions).
     *
     * @param Request $request
     * @return string
     */
    public function ProductsTable(Request $request) :string
    {
        $vals = [];

        $draw = ($request->input('draw') !== null) ? $request->input('draw') : 0;
        $length = $request->input('length');
        $start = $request->input('start');
        $order = $request->input('order');
        $search = $request->input('search');
        $client_id = ($request->input('client_id') !== null && $request->input('client_id') != 0) ? $request->input('client_id') : null;

        $limit_string = SQLHelper::getLimitString($start, $length);

        $order_string = SQLHelper::getOrderString($this->productsTableColumns, $order, $this->productsTableColumns[0]);

        $search_string = '';
        if (isset($search['value']) && $search['value'] != '') {
            $search_string = ' AND ( ';

            foreach($this->productsTableColumns as $column) {
                $name = explode( '.', $column );
                $name = end($name);

                $search_string .= ' ' . $column . ' like :' . $name . ' OR ';

                $vals[$name] = "%" . $search['value'] . "%";
            }

            $search_string = substr($search_string, 0, -3);

            $search_string .= ' ) ';
        }

        if( !is_null( $client_id ) && $client_id != 0 ) {
            $search_string .= ' AND c.id = :client_id ';
            $vals['client_id'] = $client_id;
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS p.id, c.name as client_name, p.name as product_name, t.name as type_name
          FROM products p
          JOIN clients c ON p.client_id = c.id
          JOIN product_types t ON p.product_type_id = t.id
          WHERE p.deleted_at IS NULL ' . $search_string . $order_string . $limit_string;

        $results = DB::select(DB::raw($sql), $vals);

        $clients = [];

        foreach ($results as $result) {
            $view_button = '<button class="btn btn-info" id="view_record_button" data-id="' . $result->id . '" title="' . $this->view_record_title . '"><span class="fa fa-eye"></span></button>';
            $edit_button = '<button class="btn btn-success" id="edit_record_button" data-id="' . $result->id . '" title="' . $this->edit_record_title . '"><span class="fa fa-pencil"></span></button>';
            $delete_button = '<button class="btn btn-danger" id="delete_record_button" data-id="' . $result->id . '" title="' . $this->delete_record_title . '"><span class="fa fa-trash-o"></span></button>';
            $buttons = $view_button . $edit_button . $delete_button;

            $clients[] = [
                $result->id,
                $result->client_name,
                $result->product_name,
                $result->type_name,
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
}