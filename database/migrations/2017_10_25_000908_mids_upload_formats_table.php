<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MidsUploadFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mids_upload_formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('format_name');
            $table->integer('client_id_column')->unsigned()->nullable();
            $table->integer('mid_column')->unsigned()->nullable();
            $table->integer('alias_column')->unsigned()->nullable();
            $table->integer('descriptor_column')->unsigned()->nullable();
            $table->integer('customer_service_phone_column')->unsigned()->nullable();
            $table->integer('customer_service_email_column')->unsigned()->nullable();
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
        Schema::drop('mids_upload_formats');
    }
}
