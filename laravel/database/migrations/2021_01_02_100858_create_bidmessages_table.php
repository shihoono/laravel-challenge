<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidmessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidmessages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bidinfo_id');
            $table->unsignedBigInteger('user_id');
            $table->string('message', 1000);
            $table->timestamps();

            $table->foreign('bidinfo_id')->references('id')->on('bidinfo');
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
        Schema::dropIfExists('bidmessages');
    }
}
