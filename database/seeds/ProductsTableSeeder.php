<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'client_id' => 1,
            'name' => 'Raspberry Ketone',
            'product_type_id' => 2,
            'cover_letter' => 'cover_letter.docx',
            'order_page' => 'order_page.png',
            'terms' => 'terms.docx',
        ]);

        DB::table('products')->insert([
            'client_id' => 1,
            'name' => 'Garcinia Cambogia',
            'product_type_id' => 2,
            'cover_letter' => 'cover_letter.docx',
            'order_page' => 'order_page.png',
            'terms' => 'terms.docx',
        ]);

        DB::table('products')->insert([
            'client_id' => 2,
            'name' => 'Caffeine Pills',
            'product_type_id' => 1,
            'cover_letter' => 'cover_letter.docx',
            'order_page' => 'order_page.png',
            'terms' => 'terms.docx',
        ]);

        DB::table('products')->insert([
            'client_id' => 2,
            'name' => 'Male Enhancement Pills',
            'product_type_id' => 2,
            'cover_letter' => 'cover_letter.docx',
            'order_page' => 'order_page.png',
            'terms' => 'terms.docx',
        ]);

        DB::table('products')->insert([
            'client_id' => 2,
            'name' => 'Breast Enhancement Pills',
            'product_type_id' => 2,
            'cover_letter' => 'cover_letter.docx',
            'order_page' => 'order_page.png',
            'terms' => 'terms.docx',
        ]);

        DB::table('products')->insert([
            'client_id' => 3,
            'name' => 'Alpha Muscle',
            'product_type_id' => 2,
            'cover_letter' => 'cover_letter.docx',
            'order_page' => 'order_page.png',
            'terms' => 'terms.docx',
        ]);

        DB::table('products')->insert([
            'client_id' => 4,
            'name' => 'Creatin Powder',
            'product_type_id' => 1,
            'cover_letter' => 'cover_letter.docx',
            'order_page' => 'order_page.png',
            'terms' => 'terms.docx',
        ]);
    }
}
