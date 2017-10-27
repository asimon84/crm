<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'name' => 'Test Client 1',
            'business_website' => 'www.test1.com',
            'business_phone' => '1231231234',
            'business_email' => 'test@abc.com',
            'contact_title' => 'Mr',
            'contact_name' => 'James Brown',
            'contact_phone' => '1231231234',
            'contact_email' => 'test@xyz.com',
        ]);

        DB::table('clients')->insert([
            'name' => 'Test Client 2',
            'business_website' => 'www.test2.com',
            'business_phone' => '1231231234',
            'business_email' => 'abc@123.com',
            'contact_title' => 'Mrs',
            'contact_name' => 'Paula Jones',
            'contact_phone' => '1231231234',
            'contact_email' => 'xyz@123.com',
        ]);

        DB::table('clients')->insert([
            'name' => 'Test Client 3',
            'business_website' => 'www.test3.com',
            'business_phone' => '1231231234',
            'business_email' => 'test@123.com',
            'contact_title' => 'Sir',
            'contact_name' => 'Edward Kensington',
            'contact_phone' => '1231231234',
            'contact_email' => 'a@b.c',
        ]);

        DB::table('clients')->insert([
            'name' => 'Test Client 4',
            'business_website' => 'www.test4.com',
            'business_phone' => '1231231234',
            'business_email' => 'test@666.com',
            'contact_title' => 'Lord',
            'contact_name' => 'Balmour Flabbergast',
            'contact_phone' => '1231231234',
            'contact_email' => 'a@b.c',
        ]);

        DB::table('clients')->insert([
            'name' => 'Test Client 5',
            'business_website' => 'www.test5.com',
            'business_phone' => '1231231234',
            'business_email' => 'test@777.com',
            'contact_title' => 'Miss',
            'contact_name' => 'Amelia Earheart',
            'contact_phone' => '1231231234',
            'contact_email' => 'alpha@beta.com',
        ]);
    }
}
