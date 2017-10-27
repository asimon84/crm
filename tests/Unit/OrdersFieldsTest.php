<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Portal\Orders\OrdersFields;

class OrdersFieldsTest extends TestCase
{
    /**
     * Make sure getFields method returns a non empty array
     *
     * @return void
     */
    public function testGetFields()
    {
        $result = OrdersFields::getFields();

        $this->assertNotEmpty($result);
    }

    /**
     * Make sure getEditableFields method returns a non empty array
     *
     * @return void
     */
    public function testGetEditableFields()
    {
        $result = OrdersFields::getEditableFields();

        $this->assertNotEmpty($result);
    }
}
