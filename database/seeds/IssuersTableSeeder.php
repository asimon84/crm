<?php

use Illuminate\Database\Seeder;

class IssuersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('issuers')->insert([
            'name' => 'JP Morgan Chase',
        ]);

        DB::table('issuers')->insert([
            'name' => 'Citigroup',
        ]);

        DB::table('issuers')->insert([
            'name' => 'MBNA America',
        ]);

        DB::table('issuers')->insert([
            'name' => 'Bank of America',
        ]);

        DB::table('issuers')->insert([
            'name' => 'Capital One',
        ]);

        DB::table('issuers')->insert([
            'name' => 'HSBC Bank',
        ]);

        DB::table('issuers')->insert([
            'name' => 'Providian',
        ]);

        DB::table('issuers')->insert([
            'name' => 'Wells Fargo',
        ]);

        DB::table('issuers')->insert([
            'name' => 'U.S. Bancorp',
        ]);

        DB::table('issuers')->insert([
            'name' => 'USAA Federal Savings',
        ]);
    }
}
