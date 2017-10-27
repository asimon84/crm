<?php

namespace App\Portal\Helpers\History;

/**
 * Interface HistoryInterface
 *
 * Interface used by any basic history entry for a record type to store actions taken upon a record in the database
 * by a currently authenticated user.
 *
 * @package App\Portal\Helpers\History
 */
interface HistoryInterface
{
    /**
     * Insert into History
     *
     * This method inserts an entry into the history table for this record type.
     *
     * @param int $user_id
     * @param string $action
     * @param int $record_id
     */
    public static function insert(int $user_id, string $action, int $record_id);
}
