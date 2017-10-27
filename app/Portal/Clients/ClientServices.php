<?php

namespace App\Portal\Clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class ClientServices
 *
 * This class is the model for the Client Services database table
 *
 * @package App\Portal\Clients
 */
class ClientServices extends Model
{
    /**
     * @var string
     */
    protected $table = 'client_services';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get Client Services Names
     *
     * Return array of the names of Client Services
     *
     * @param int $client_id
     * @return array
     */
    public static function getClientServicesNames( $client_id ) :array
    {
        return DB::table('client_services')
            ->join('services', 'services.id', '=', 'client_services.service_levels_id')
            ->where('client_services.client_id', '=', $client_id)
            ->get();
    }

    /**
     * Toggle Service
     *
     * Toggle a service on or off for a passed client ID
     *
     * @param boolean $active
     * @param int $client_id
     * @param int $service_levels_id
     */
    public static function toggleService(boolean $active, int $client_id, int $service_levels_id) {
        if( $active == 'true' ) {
            $cs = new ClientServices();

            $cs->client_id = $client_id;
            $cs->service_levels_id = $service_levels_id;

            $cs->save();

            ClientServicesHistory::insert($client_id, 'added', $service_levels_id);
        } else if ( $active == 'false' ) {
            ClientServices::where([
                'client_id' => $client_id,
                'service_levels_id' => $service_levels_id
            ])->delete();

            ClientServicesHistory::insert($client_id, 'deleted', $service_levels_id);
        }
    }
}