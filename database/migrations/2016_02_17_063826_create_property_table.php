<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create in MySQL
        /*Schema::connection('mysql')->create('category', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
        });*/
        Schema::connection('mysql')->create('property', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('loc_id')->unsigned();
            $table->integer('prop_type_id')->unsigned();
            $table->integer('prop_purpose_id')->unsigned();
            $table->integer('prop_category_id')->unsigned();
            $table->string('title', 100);
            $table->float('price');
            $table->float('area');
            $table->string('area_type');
            $table->text('description');
            $table->text('image_url');
            $table->integer('views');
            $table->tinyInteger('status');
            $table->timestamps();
        });

        Schema::connection('mysql')->table('property', function($table) {
            $table->foreign('loc_id')->references('id')->on('location');
            $table->foreign('prop_type_id')->references('id')->on('property_type');
            $table->foreign('prop_purpose_id')->references('id')->on('property_purpose');
            $table->foreign('prop_category_id')->references('id')->on('property_category');
        });

        //Create In Mongo
        /*Schema::connection('mongoDB')->create('property', function (Blueprint $table) {

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
        Schema::connection('mysql')->drop('property');

        //Drop From Mongo
        //Schema::connection('mongoDB')->drop('property');
    }
}
