<?php

namespace App\Portal\Clients;

use Illuminate\Database\Eloquent\Model;
use App\Portal\Helpers\History\HistoryInterface;

/**
 * Class ClientServicesHistory
 *
 * Basic history entry for a record type to store actions taken upon a record in the database by a currently
 * authenticated user.
 *
 * @package App\Portal\Clients
 */
class ClientServicesHistory extends Model implements HistoryInterface
{
    /**
     * @var string
     */
    protected $table = 'client_services_history';

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
     * Insert into History
     *
     * This method inserts an entry into the history table for this record type.
     *
     * @param int $user_id
     * @param string $action
     * @param int $record_id
     */
    public static function insert(int $user_id, string $action, int $record_id)
    {
        $ch = new ClientServicesHistory();

        $ch->user_id = $user_id;
        $ch->action = $action;
        $ch->client_id = $record_id;

        $ch->save();
    }
}