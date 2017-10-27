<?php

namespace App\Portal\MIDs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MIDs
 *
 * This class is the model for the MIDs database table
 *
 * @package App\Portal\MIDs
 */
class MIDs extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'mids';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}