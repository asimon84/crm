<?php

namespace App\Portal\Products;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductTypes
 *
 * This class is the model for the Product Types database table
 *
 * @package App\Portal\Products
 */
class ProductTypes extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_types';

    /**
     * @var int
     */
    const STRAIGHT_SALE = 1;

    /**
     * @var int
     */
    const RECURRING_BILLING = 2;
}