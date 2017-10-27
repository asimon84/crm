<?php

use Illuminate\Database\Seeder;

class OrdersPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders_permissions')->insert([
            'name' => 'Add Orders',
            'field_name' => 'add_orders',
        ]);
    }
}
