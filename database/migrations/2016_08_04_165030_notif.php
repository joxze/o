<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notif', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject', 100)->nullabel();
            $table->text('message');
            $table->integer('users_id')->unsigned();
            $table->integer('status')->default(1);
            $table->integer('sender_id')->unsigned()->nullabel();
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('sender_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notif');
    }
}
