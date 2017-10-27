<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Portal\Response\Response;

class ResponseTest extends TestCase
{
    /**
     * Make sure formatResponse returns the expected response in the format we require
     *
     * @return void
     */
    public function testResponse()
    {
        $expected = [
            'success' => true,
            'code' => 200,
            'message' => '',
            'data' => [],
        ];

        $result = Response::formatResponse(true, 200, '', []);

        $this->assertEquals($expected, $result);
    }

    /**
     * Make sure an empty formatResponse method call returns a default failure response
     *
     * @return void
     */
    public function testEmptyResponse()
    {
        $expected = [
            'success' => false,
            'code' => 500,
            'message' => '',
            'data' => [],
        ];

        $result = Response::formatResponse();

        $this->assertEquals($expected, $result);
    }
}
