<?php

use Illuminate\Database\Seeder;

class ClientsPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients_permissions')->insert([
            'name' => 'Add Clients',
            'field_name' => 'add_clients',
        ]);
    }
}
