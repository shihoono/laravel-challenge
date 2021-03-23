<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsBidinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bidinfo', function (Blueprint $table) {
            $table->string('bidder_name', 100)->after('price')->nullable(true);
            $table->string('bidder_address', 255)->after('bidder_name')->nullable(true);
            $table->string('bidder_phone_number', 13)->after('bidder_address')->nullable(true);
            $table->integer('trading_status')->length(1)->default(false)->after('bidder_phone_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bidinfo', function (Blueprint $table) {
            $table->dropColumn('bidder_name', 'bidder_address', 'bidder_phone_number', 'trading_status');
        });
    }
}
