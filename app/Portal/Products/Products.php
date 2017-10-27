<?php

namespace App\Portal\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Products
 *
 * This class is the model for the Products database table
 *
 * @package App\Portal\Products
 */
class Products extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'products';

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