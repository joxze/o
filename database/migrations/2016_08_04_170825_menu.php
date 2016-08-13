<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Menu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('url', 250)->nullabel();
            $table->integer('parent')->nullabel();
            $table->string('label_front', 500)->nullabel();
            $table->string('label_end', 500)->nullabel();
            $table->integer('status')->default(1);
            $table->integer('group_menu_id')->unsigned();
            $table->integer('position')->nullabel();
            $table->integer('level')->nullabel();
            $table->timestamps();
            $table->foreign('group_menu_id')->references('id')->on('group_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu');
    }
}
