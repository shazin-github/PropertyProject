<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create In MySQL
        Schema::connection('mysql')->create('location', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('address', 255);
            $table->string('city', 100)->index();
            $table->string('zip', 50)->index();
            $table->string('state', 100)->index();
            $table->string('country', 100)->index();
            $table->float('latitude');
            $table->float('longitude');
            $table->timestamps();
        });

        //Create In Mongo
        Schema::connection('mongoDB')->create('location', function (Blueprint $table) {

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
        Schema::connection('mysql')->drop('location');

        //Drop From Mongo
        Schema::connection('mongoDB')->drop('location');
    }
}
