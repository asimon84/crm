<?php

use Illuminate\Database\Seeder;

class OrdersAgentPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders_agent_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 1,
        ]);
    }
}
