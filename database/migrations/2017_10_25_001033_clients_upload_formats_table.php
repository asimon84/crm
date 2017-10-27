<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientsUploadFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_upload_formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('format_name');
            $table->integer('name_column')->unsigned()->nullable();
            $table->integer('business_website_column')->unsigned()->nullable();
            $table->integer('business_phone_column')->unsigned()->nullable();
            $table->integer('business_email_column')->unsigned()->nullable();
            $table->integer('contact_title_column')->unsigned()->nullable();
            $table->integer('contact_name_column')->unsigned()->nullable();
            $table->integer('contact_phone_column')->unsigned()->nullable();
            $table->integer('contact_email_column')->unsigned()->nullable();
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
        Schema::drop('clients_upload_formats');
    }
}
