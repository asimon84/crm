<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Portal\Helpers\SQL\SQLHelper;

class SQLHelperTest extends TestCase
{
    /**
     * Make sure getLimitString returns a proper SQL limit string
     *
     * @return void
     */
    public function testLimitString()
    {
        $limit_string = SQLHelper::getLimitString(0, 1);

        $this->assertEquals($limit_string,' LIMIT 0, 1');
    }

    /**
     * Make sure a null getLimitString method call returns an empty SQL limit string
     *
     * @return void
     */
    public function testLimitStringEmpty()
    {
        $limit_string = SQLHelper::getLimitString(null, null);

        $this->assertEmpty($limit_string);
    }

    /**
     * Make sure getOrderString returns a proper SQL order by string
     *
     * @return void
     */
    public function testGetOrderString()
    {
        $columns = [];

        $order = [];

        $order_string = SQLHelper::getOrderString($columns, $order, 'test');

        $this->assertEquals($order_string,' ORDER BY test asc ');
    }

    /**
     * Make sure a modified getOrderString method call returns a proper SQL order by string
     *
     * @return void
     */
    public function testGetOrderStringChange()
    {
        $columns = [];
        $columns[0] = 'test2';

        $order = [];
        $order[0]['column'] = 0;
        $order[0]['dir'] = 'desc';

        $order_string = SQLHelper::getOrderString($columns, $order, 'test');

        $this->assertEquals($order_string,' ORDER BY test2 desc ');
    }

    /**
     * Make sure a null getOrderString method call returns an empty SQL order by string
     *
     * @return void
     */
    public function testGetOrderStringEmpty()
    {
        $columns = [];

        $order = [];

        $limit_string = SQLHelper::getOrderString($columns, $order, '');

        $this->assertEmpty($limit_string);
    }

    /**
     * Make sure getDateRangeString returns a proper SQL date range string
     *
     * @return void
     */
    public function testGetDateRangeString()
    {
        $date_string = SQLHelper::getDateRangeString('test', date('Y-m-d'), date('Y-m-d'));

        $this->assertEquals($date_string,' AND test >= :start_date AND test <= :end_date ');
    }

    /**
     * Make sure a null getDateRangeString method call returns an empty SQL order by string
     *
     * @return void
     */
    public function testGetDateRangeStringEmpty()
    {
        $date_string = SQLHelper::getDateRangeString('', null, null);

        $this->assertEmpty($date_string);
    }

    /**
     * Make sure getClientString returns a proper SQL client string
     *
     * @return void
     */
    public function testGetClientString()
    {
        $client_string = SQLHelper::getClientString('test', 1);

        $this->assertEquals($client_string,' AND test = :client_id ');
    }

    /**
     * Make sure a null getClientString method call returns an empty SQL order by string
     *
     * @return void
     */
    public function testGetClientStringEmpty()
    {
        $client_string = SQLHelper::getClientString('', null);

        $this->assertEmpty($client_string);
    }
}
