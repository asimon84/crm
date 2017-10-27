<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Portal\Permissions\Permissions;
use App\Portal\Helpers\UploadFormats\MIDsUploadFormats;
use App\Portal\Clients\Clients;
use App\Portal\MIDs\MIDs;
use App\Portal\MIDs\MIDsFields;
use Illuminate\Support\Facades\DB;
use App\Portal\Helpers\Traits\AddRecord;
use App\Portal\Helpers\Traits\ViewRecord;
use App\Portal\Helpers\Traits\EditRecord;
use App\Portal\Helpers\Traits\DeleteRecord;
use App\Portal\Helpers\Traits\UploadCSV;
use App\Portal\Helpers\Traits\CSVMapperFormats;
use App\Portal\Helpers\SQL\SQLHelper;

/**
 * Class MIDsAdminController
 *
 * This is the controller for the MIDs Administration page of the application.  This class contains the methods to
 * load the view for the page, the methods to load any table and/or chart data required, and to attach any traits this
 * page will contain.
 *
 * @package App\Http\Controllers
 */
class MIDsAdminController extends Controller
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
    public $view = 'mids-admin';

    /**
     * @var string
     */
    protected $module = 'mids';

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
    protected $clientMIDsTableColumns = [
        'c.id',
        'c.name',
    ];

    /**
     * @var array
     */
    protected $MIDsTableColumns = [
        'm.id',
        'm.mid',
        'c.name',
        'm.alias',
        'm.descriptor',
        'm.customer_service_phone',
        'm.active',
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

        $this->fields = MIDsFields::getFields();
        $this->editable_fields = MIDsFields::getEditableFields();
        $this->record_class = '\App\Portal\MIDs\MIDs';
        $this->field_class = '\App\Portal\MIDs\MIDsFields';
        $this->format_class = '\App\Portal\Helpers\UploadFormats\MIDsUploadFormats';
        $this->history_class = '\App\Portal\MIDs\MIDsHistory';
        $this->identifier_field = 'mid';
        $this->history_id = 'mid_id';
        $this->view_record_title = 'View MID';
        $this->add_record_title = 'Add MID';
        $this->edit_record_title = 'Edit MID';
        $this->delete_record_title = 'Delete MID';
        $this->upload_csv_title = 'Upload MIDs';
    }

    /**
     * Show the MIDs Admin Page
     *
     * This method returns the view for the MIDs Administration page.  All variables used within the view must be
     * included here.  Anything requiring Authentication must be done here as it cannot be done in the constructor as
     * of Laravel 5.3
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->permissions = [(new Permissions)->getMIDsPermissions(Auth::id())[0]];

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
            'formats' => MIDsUploadFormats::all(),
            'clients' => Clients::all(),
            'mids' => MIDs::all(),
            'response' => $request->old('response'),
        ]);
    }

    /**
     * Return data for Clients DataTable on MIDs Admin Panel
     *
     * This method returns the JSON encoded data required by the Clients MID Overview table on the MIDs
     * Administration page.  This shows each individual Client and their total MIDs and whether they are active or not.
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

        $order_string = SQLHelper::getOrderString($this->clientMIDsTableColumns, $order, 'c.id');

        $search_string = '';
        if (isset($search['value']) && $search['value'] != '') {
            $search_string = ' AND ( ';

            foreach($this->clientMIDsTableColumns as $column) {
                $name = explode( '.', $column );
                $name = end($name);

                $search_string .= ' ' . $column . ' like :' . $name . ' OR ';

                $vals[$name] = "%" . $search['value'] . "%";
            }

            $search_string = substr($search_string, 0, -3);

            $search_string .= ' ) ';
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS ' . implode( ', ', $this->clientMIDsTableColumns ) . ',
          (SELECT count(*) FROM mids m WHERE m.client_id = c.id AND m.active = 1 AND m.deleted_at IS NULL) as active_mids_count, (SELECT count(*) FROM mids m WHERE m.client_id = c.id AND m.deleted_at IS NULL) as mids_count
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
                $result->active_mids_count,
                $result->mids_count,
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
     * Return data for MIDs DataTable on MIDs Admin Panel
     *
     * This method returns the JSON encoded data required by the main MIDs Administration table on the MIDs
     * Administration page.  This will show the MID itself, with interactivity to view the complete set of MID
     * information, as well as the editing, and activating/deactivating of a MID (if the authenticated user has the
     * required permissions).
     *
     * @param Request $request
     * @return string
     */
    public function MIDsTable(Request $request) :string
    {
        $vals = [];

        $draw = ($request->input('draw') !== null) ? $request->input('draw') : 0;
        $length = $request->input('length');
        $start = $request->input('start');
        $order = $request->input('order');
        $search = $request->input('search');
        $client_id = ($request->input('client_id') !== null && $request->input('client_id') != 0) ? $request->input('client_id') : null;

        $limit_string = SQLHelper::getLimitString($start, $length);

        $order_string = SQLHelper::getOrderString($this->MIDsTableColumns, $order, 'c.id');

        $search_string = '';
        if (isset($search['value']) && $search['value'] != '') {
            $search_string = ' AND ( ';

            foreach($this->MIDsTableColumns as $column) {
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

        $sql = 'SELECT SQL_CALC_FOUND_ROWS ' . implode( ', ', $this->MIDsTableColumns ) . '
          FROM mids m
          JOIN clients c ON c.id = m.client_id
          WHERE m.deleted_at IS NULL ' . $search_string . $order_string . $limit_string;

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
                $result->mid,
                $result->alias,
                $result->descriptor,
                $result->customer_service_phone,
                $active = ( $result->active ) ? 'Active' : 'Inactive',
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