<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Portal\Products\ProductsFields;

class ProductsFieldsTest extends TestCase
{
    /**
     * Make sure getFields method returns a non empty array
     *
     * @return void
     */
    public function testGetFields()
    {
        $result = ProductsFields::getFields();

        $this->assertNotEmpty($result);
    }

    /**
     * Make sure getEditableFields method returns a non empty array
     *
     * @return void
     */
    public function testGetEditableFields()
    {
        $result = ProductsFields::getEditableFields();

        $this->assertNotEmpty($result);
    }
}
