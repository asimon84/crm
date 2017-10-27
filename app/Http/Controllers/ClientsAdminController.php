<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Portal\Permissions\Permissions;
use App\Portal\Helpers\UploadFormats\ClientsUploadFormats;
use App\Portal\Clients\Clients;
use App\Portal\Clients\ClientServices;
use App\Portal\Clients\ClientsFields;
use App\Portal\Services\Services;
use Illuminate\Support\Facades\DB;
use App\Portal\Helpers\Traits\AddRecord;
use App\Portal\Helpers\Traits\ViewRecord;
use App\Portal\Helpers\Traits\EditRecord;
use App\Portal\Helpers\Traits\DeleteRecord;
use App\Portal\Helpers\Traits\UploadCSV;
use App\Portal\Helpers\Traits\CSVMapperFormats;
use App\Portal\Helpers\SQL\SQLHelper;

/**
 * Class ClientsAdminController
 *
 * This is the controller for the Clients Administration page of the application.  This class contains the methods to
 * load the view for the page, the methods to load any table and/or chart data required, and to attach any traits this
 * page will contain.
 *
 * @package App\Http\Controllers
 */
class ClientsAdminController extends Controller
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
    protected $view = 'clients-admin';

    /**
     * @var string
     */
    protected $module = 'clients';

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
    protected $adminTableColumns = [
        'c.id',
        'c.name',
        'c.contact_name',
        'c.contact_phone',
        'c.contact_email',
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

        $this->fields = ClientsFields::getFields();
        $this->editable_fields = ClientsFields::getEditableFields();
        $this->record_class = '\App\Portal\Clients\Clients';
        $this->field_class = '\App\Portal\Clients\ClientsFields';
        $this->history_class = '\App\Portal\Clients\ClientsHistory';
        $this->format_class = '\App\Portal\Helpers\UploadFormats\ClientsUploadFormats';
        $this->identifier_field = 'name';
        $this->history_id = 'client_id';
        $this->view_record_title = 'View Client';
        $this->add_record_title = 'Add Client';
        $this->edit_record_title = 'Edit Client';
        $this->delete_record_title = 'Delete Client';
        $this->upload_csv_title = 'Upload Clients';
    }

    /**
     * Show the Clients Admin Page
     *
     * This method returns the view for the Clients Administration page.  All variables used within the view must be
     * included here.  Anything requiring Authentication must be done here as it cannot be done in the constructor as
     * of Laravel 5.3
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->permissions = [(new Permissions)->getClientsPermissions(Auth::id())[0]];

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
            'formats' => ClientsUploadFormats::all(),
            'clients' => Clients::all(),
            'response' => $request->old('response'),
        ]);
    }

    /**
     * Return data for Clients DataTable on Clients Admin Panel
     *
     * This method returns the JSON encoded data required by the Clients Administration table on the Clients
     * Administration page.  This will show the Clients itself, with interactivity to view the complete set of record
     * information, as well as the editing of the record (if the authenticated user has the required permissions).
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

        $order_string = SQLHelper::getOrderString($this->adminTableColumns, $order, $this->adminTableColumns[0]);

        $search_string = '';
        if (isset($search['value']) && $search['value'] != '') {
            $search_string = ' AND ( ';

            foreach($this->adminTableColumns as $column) {
                $name = explode( '.', $column );
                $name = end($name);

                $search_string .= ' ' . $column . ' like :' . $name . ' OR ';

                $vals[$name] = "%" . $search['value'] . "%";
            }

            $search_string = substr($search_string, 0, -3);

            $search_string .= ' ) ';
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS c.*
          FROM clients c
          WHERE c.deleted_at IS NULL ' . $search_string . ' GROUP BY c.id ' . $order_string . $limit_string;

        $results = DB::select(DB::raw($sql), $vals);

        $clients = [];

        foreach ($results as $result) {
            $view_button = '<button class="btn btn-info" id="view_record_button" data-id="' . $result->id . '" title="' . $this->view_record_title . '"><span class="fa fa-eye"></span></button>';
            $edit_button = '<button class="btn btn-success" id="edit_record_button" data-id="' . $result->id . '" title="' . $this->edit_record_title . '"><span class="fa fa-pencil"></span></button>';
            $delete_button = '<button class="btn btn-danger" id="delete_record_button" data-id="' . $result->id . '" title="' . $this->delete_record_title . '"><span class="fa fa-trash-o"></span></button>';
            $buttons = $view_button . $edit_button . $delete_button;

            $clients[] = [
                $result->id,
                $result->name,
                $result->contact_title . ' ' . $result->contact_name,
                $result->contact_phone,
                $result->contact_email,
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