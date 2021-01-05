<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reviewer_id');
            $table->unsignedBigInteger('reviewee_id');
            $table->unsignedBigInteger('bidinfo_id');
            $table->integer('rate')->length(1);
            $table->string('comment', 1000);
            $table->timestamps();

            $table->foreign('reviewer_id')->references('id')->on('users');
            $table->foreign('reviewee_id')->references('id')->on('users');
            $table->foreign('bidinfo_id')->references('id')->on('bidinfo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
