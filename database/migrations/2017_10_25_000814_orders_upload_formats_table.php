<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersUploadFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_upload_formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('format_name');
            $table->integer('client_id_column')->unsigned()->nullable();
            $table->integer('mid_id_column')->unsigned()->nullable();
            $table->integer('order_id_column')->unsigned()->nullable();
            $table->integer('card_association_id_column')->unsigned()->nullable();
            $table->integer('card_number_column')->unsigned()->nullable();
            $table->integer('bin_column')->unsigned()->nullable();
            $table->integer('last_four_column')->unsigned()->nullable();
            $table->integer('arn_column')->unsigned()->nullable();
            $table->integer('amount_column')->unsigned()->nullable();
            $table->integer('currency_id_column')->unsigned()->nullable();
            $table->integer('tracking_number_column')->unsigned()->nullable();
            $table->integer('product_id_column')->unsigned()->nullable();
            $table->integer('transaction_date_column')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders_upload_formats');
    }
}
