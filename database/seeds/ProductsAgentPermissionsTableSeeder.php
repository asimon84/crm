<?php

use Illuminate\Database\Seeder;

class ProductsAgentPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products_agent_permissions')->insert([
            'user_id' => 1,
            'permission_id' => 1,
        ]);
    }
}
