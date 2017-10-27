<?php

namespace App\Portal\MIDs;

use Illuminate\Database\Eloquent\Model;
use App\Portal\Helpers\History\HistoryInterface;

/**
 * Class MIDsHistory
 *
 * Basic history entry for a record type to store actions taken upon a record in the database by a currently
 * authenticated user.
 *
 * @package App\Portal\MIDs
 */
class MIDsHistory extends Model implements HistoryInterface
{
    /**
     * @var string
     */
    protected $table = 'mids_history';

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
        $mh = new MIDsHistory();

        $mh->user_id = $user_id;
        $mh->action = $action;
        $mh->mid_id = $record_id;

        $mh->save();
    }
}