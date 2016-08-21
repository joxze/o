<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assign_id')->unsigned();
            $table->integer('rules_id')->unsigned();
            $table->foreign('assign_id')->references('id')->on('assign');
            $table->foreign('rules_id')->references('id')->on('rules');
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
        Schema::drop('assign_rules');
    }
}
