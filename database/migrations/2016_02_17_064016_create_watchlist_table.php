<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create in MySQL
        Schema::connection('mysql')->create('watchlist', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('property_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::connection('mysql')->table('watchlist', function($table) {
            $table->foreign('property_id')->references('id')->on('property');
            $table->foreign('user_id')->references('id')->on('users');
        });

        //Create In Mongo
        Schema::connection('mongoDB')->create('watchlist', function (Blueprint $table) {

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop From MySQL
        Schema::connection('mysql')->drop('watchlist');

        //Drop From Mongo
        Schema::connection('mongoDB')->drop('watchlist');
    }
}
