<?php

use Illuminate\Database\Seeder;

class DashboardPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dashboard_permissions')->insert([
            'name' => 'Switch Clients',
            'field_name' => 'switch_clients',
        ]);
    }
}
