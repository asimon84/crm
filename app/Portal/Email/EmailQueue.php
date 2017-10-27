<?php

namespace App\Portal\Email;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailQueue
 *
 * This class is the model for the Alert Email Queue database table
 *
 * @package App\Portal\Email
 */
class EmailQueue extends Model
{
    /**
     * @var string
     */
    protected $table = 'alert_email_queue';

    /**
     * Has Emails Ready For Sending
     *
     * Return a boolean to signify if this client has any emails queued for sending
     *
     * @param int $client_id
     * @return bool
     */
    public static function hasEmailsReadyForSending( int $client_id ) :bool
    {
        return false;
    }
}