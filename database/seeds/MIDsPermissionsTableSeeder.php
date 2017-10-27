<?php

use Illuminate\Database\Seeder;

class MIDsPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mids_permissions')->insert([
            'name' => 'Add MIDs',
            'field_name' => 'add_mids',
        ]);
    }
}
