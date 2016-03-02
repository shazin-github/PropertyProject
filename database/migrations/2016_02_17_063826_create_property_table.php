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
        Schema::connection('mysql')->create('property', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('loc_id')->unsigned();
            $table->string('title', 100);
            $table->float('price');
            $table->float('area');
            $table->text('description');
            $table->string('purpose')->index();
            $table->string('type')->index();
            $table->string('category')->index();
            $table->text('image_url');
            $table->tinyInteger('status');
            $table->timestamps();
        });

        Schema::connection('mysql')->table('property', function($table) {
            $table->foreign('loc_id')->references('id')->on('location');
        });

        //Create In Mongo
        Schema::connection('mongoDB')->create('property', function (Blueprint $table) {

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
        Schema::connection('mysql')->drop('property');

        //Drop From Mongo
        Schema::connection('mongoDB')->drop('property');
    }
}
