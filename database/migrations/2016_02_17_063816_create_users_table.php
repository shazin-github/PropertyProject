<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Create In MySQL
        Schema::connection('mysql')->create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('loc_id')->unsigned();
            $table->string('username');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique()->index();
            $table->string('password', 60);
            $table->string('phone');
            $table->text('image_url');
            $table->tinyInteger('status');
            $table->string('confirmation_code');
            $table->rememberToken();
            $table->timestamps();
        });

        /*Schema::connection('mysql')->table('users', function($table) {
                $table->foreign('loc_id')->references('id')->on('location');
        });*/

        //Create In Mongo
        /*Schema::connection('mongoDB')->create('users', function (Blueprint $table) {

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
        Schema::connection('mysql')->drop('users');

        //Drop From Mongo
        //Schema::connection('mongoDB')->drop('users');
    }
}
