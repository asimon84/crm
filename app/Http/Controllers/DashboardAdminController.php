<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Portal\Permissions\Permissions;
use Illuminate\Support\Facades\DB;
use App\Portal\Services\Services;

/**
 * Class DashboardAdminController
 *
 * This is the controller for the Dashboard Administration page of the application.  This class contains the methods to
 * load the view for the page, the methods to load any table and/or chart data required, and to attach any traits this
 * page will contain.
 *
 * @package App\Http\Controllers
 */
class DashboardAdminController extends Controller
{
    /**
     * @var string
     */
    public $view = 'dashboard-admin';

    /**
     * @var array
     */
    protected $permissions = [];

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
    }

    /**
     * Show the Dashboard Admin Page
     *
     * This method returns the view for the Dashboard Administration page.  All variables used within the view must be
     * included here.  Anything requiring Authentication must be done here as it cannot be done in the constructor as
     * of Laravel 5.3
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->permissions = [(new Permissions)->getDashboardPermissions(Auth::id())[0]];

        return view($this->view, [
            'permissions' => $this->permissions,
        ]);
    }

    /**
     * Return the data for the Overview line chart on the Dashboard page
     *
     * This method returns a JSON encoded string that contains chart data for the overview chart on the Dashboard page.
     * This chart contains data for all record types over a passed date range.  It will display a line chart for all
     * record types.
     *
     * @param Request $request
     * @return string
     */
    public function getOverviewChartData(Request $request) :string
    {
        $start_date = new \DateTime($request->input('start_date'));
        $end_date = new \DateTime($request->input('end_date'));
        $days = $start_date->diff($end_date)->format('%a');

        $results[0][] = 'x';
        $results[1][] = 'Orders';

        for ($i = 0; $i <= $days; $i++) {
            $results[0][] =  $start_date->format('Y-m-d');

            $vals['start_date'] = $start_date->format('Y-m-d') . ' 00:00:00';
            $vals['end_date'] = $start_date->format('Y-m-d') . ' 23:59:59';

            $sql = 'SELECT COUNT(o.id) as total
              FROM orders o
              JOIN mids m ON o.mid_id = m.id
              JOIN clients c ON m.client_id = c.id
              WHERE o.transaction_date >= :start_date AND o.transaction_date <= :end_date
              AND c.deleted_at IS NULL AND m.deleted_at IS NULL AND m.active = 1 AND o.deleted_at IS NULL
              GROUP BY o.transaction_date';

            $result = DB::select(DB::raw($sql), $vals);

            if (empty($result)) {
                $results[1][] = 0;
            } else {
                $results[1][] = $result[0]->total;
            }

            $start_date->add(new \DateInterval('P1D'));
        }

        return json_encode(
            [
                'success' => true,
                'data' => $results
            ]
        );
    }
}