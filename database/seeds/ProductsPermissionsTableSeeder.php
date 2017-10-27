<?php

use Illuminate\Database\Seeder;

class ProductsPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products_permissions')->insert([
            'name' => 'Add Products',
            'field_name' => 'add_products',
        ]);
    }
}
