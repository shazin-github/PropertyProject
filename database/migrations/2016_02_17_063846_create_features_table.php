<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create in MySQL
        Schema::connection('mysql')->create('features', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('property_id')->unsigned();
            $table->integer('bedrooms')->index();
            $table->integer('bathrooms')->index();
            $table->text('utilities');
            $table->text('description');
            $table->text('other');
            $table->timestamps();
        });

        Schema::connection('mysql')->table('features', function($table) {
            $table->foreign('property_id')->references('id')->on('property');
        });

        //Create In Mongo
        Schema::connection('mongoDB')->create('features', function (Blueprint $table) {

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
        Schema::connection('mysql')->drop('features');

        //Drop From Mongo
        Schema::connection('mongoDB')->drop('features');
    }
}
