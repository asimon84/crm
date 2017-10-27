<?php

namespace App\Portal\Clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Clients
 *
 * This class is the model for the Clients database table
 *
 * @package App\Portal\Clients
 */
class Clients extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'clients';

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