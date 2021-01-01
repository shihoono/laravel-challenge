<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidinfo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('biditem_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('price');
            $table->timestamps();

            $table->foreign('biditem_id')->references('id')->on('biditems');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bidinfo');
    }
}
