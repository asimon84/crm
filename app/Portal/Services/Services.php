<?php

namespace App\Portal\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Services
 *
 * This class is the model for the Services database table
 *
 * @package App\Portal\Services
 */
class Services extends Model
{
    /**
     * @var string
     */
    protected $table = 'services';

    /**
     * @var int
     */
    const RETRIEVALS_SERVICE = 1;

    /**
     * @var int
     */
    const ALERTS_SERVICE = 2;

    /**
     * @var int
     */
    const CHARGEBACKS_SERVICE = 3;

    /**
     * @var int
     */
    const REPORTING_SERVICE = 4;
}