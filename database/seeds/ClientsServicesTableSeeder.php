<?php

use Illuminate\Database\Seeder;

class ClientsServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('client_services')->insert([
            'client_id' => 1,
            'service_levels_id' => 2,
        ]);

        DB::table('client_services')->insert([
            'client_id' => 2,
            'service_levels_id' => 2,
        ]);

        DB::table('client_services')->insert([
            'client_id' => 3,
            'service_levels_id' => 3,
        ]);

        DB::table('client_services')->insert([
            'client_id' => 4,
            'service_levels_id' => 1,
        ]);

        DB::table('client_services')->insert([
            'client_id' => 5,
            'service_levels_id' => 1,
        ]);

        DB::table('client_services')->insert([
            'client_id' => 5,
            'service_levels_id' => 2,
        ]);

        DB::table('client_services')->insert([
            'client_id' => 5,
            'service_levels_id' => 3,
        ]);

        DB::table('client_services')->insert([
            'client_id' => 5,
            'service_levels_id' => 4,
        ]);
    }
}
