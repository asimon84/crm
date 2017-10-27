<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Portal\Clients\ClientsFields;

class ClientsFieldsTest extends TestCase
{
    /**
     * Make sure getFields method returns a non empty array
     *
     * @return void
     */
    public function testGetFields()
    {
        $result = ClientsFields::getFields();

        $this->assertNotEmpty($result);
    }

    /**
     * Make sure getEditableFields method returns a non empty array
     *
     * @return void
     */
    public function testGetEditableFields()
    {
        $result = ClientsFields::getEditableFields();

        $this->assertNotEmpty($result);
    }
}
