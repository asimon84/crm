<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Portal\MIDs\MIDsFields;

class MIDsFieldsTest extends TestCase
{
    /**
     * Make sure getFields method returns a non empty array
     *
     * @return void
     */
    public function testGetFields()
    {
        $result = MIDsFields::getFields();

        $this->assertNotEmpty($result);
    }

    /**
     * Make sure getEditableFields method returns a non empty array
     *
     * @return void
     */
    public function testGetEditableFields()
    {
        $result = MIDsFields::getEditableFields();

        $this->assertNotEmpty($result);
    }
}
