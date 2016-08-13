<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Assign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign', function (Blueprint $table) {
            $table->increments('id');
            $table->string('controller', 200);
            $table->string('action', 200);
            $table->string('url', 200)->nullable();
            $table->enum('method', ['get', 'post', 'put', 'delete', 'any']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assign');
    }
}
