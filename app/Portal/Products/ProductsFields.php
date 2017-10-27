<?php

namespace App\Portal\Products;

use App\Portal\Helpers\Fields\FieldsInterface;

/**
 * Products Fields
 *
 * Class to get array of fields specific to this class, used mainly by the add and edit traits of a controller.
 *
 * @package App\Portal\Products
 */
class ProductsFields implements FieldsInterface
{
    /**
     * @var array
     */
    protected static $fields = [
        [
            'name' => 'client_id',
            'label' => 'Client',
            'required' => true,
            'editable' => false,
            'type' => 'integer',
            'size' => 11,
        ],
        [
            'name' => 'name',
            'label' => 'Product Name',
            'required' => true,
            'editable' => true,
            'type' => 'string',
            'size' => 255,
        ],
        [
            'name' => 'product_type_id',
            'label' => 'Product Type',
            'required' => true,
            'editable' => true,
            'type' => 'integer',
            'size' => 11,
        ],
        [
            'name' => 'cover_letter',
            'label' => 'Cover Letter',
            'required' => true,
            'editable' => true,
            'type' => 'html',
            'size' => 255,
        ],
        [
            'name' => 'order_page',
            'label' => 'Order Page',
            'required' => true,
            'editable' => true,
            'type' => 'html',
            'size' => 255,
        ],
        [
            'name' => 'terms',
            'label' => 'Terms & Conditions',
            'required' => true,
            'editable' => true,
            'type' => 'html',
            'size' => 255,
        ],
    ];

    /**
     * Get Fields
     *
     * Return array of all record fields, no exceptions.
     *
     * @return array
     */
    public static function getFields() :array
    {
        return self::$fields;
    }

    /**
     * Get Editable Fields
     *
     * Return array of only the fields that are marked editable
     *
     * @return array
     */
    public static function getEditableFields() :array
    {
        $fields = [];

        foreach(self::$fields as $field) {
            if($field['editable']) {
                $fields[] = $field;
            }
        }

        return $fields;
    }
}