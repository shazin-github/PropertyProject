<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create in MySQL
        Schema::connection('mysql')->create('sold_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('property_id')->unsigned();
            $table->integer('seller_id')->unsigned();
            $table->integer('buyer_id')->unsigned();
            $table->float('price_sqft');
            $table->float('total_price');
            $table->text('description');
            $table->timestamps();
        });

        Schema::connection('mysql')->table('sold_history', function($table) {
            $table->foreign('property_id')->references('id')->on('property');
            $table->foreign('seller_id')->references('id')->on('seller');
            $table->foreign('buyer_id')->references('id')->on('buyer');
        });

        //Create In Mongo
        /*Schema::connection('mongoDB')->create('sold_history', function (Blueprint $table) {

        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop From MySQL
        Schema::connection('mysql')->drop('sold_history');

        //Drop From Mongo
        //Schema::connection('mongoDB')->drop('sold_history');
    }
}
