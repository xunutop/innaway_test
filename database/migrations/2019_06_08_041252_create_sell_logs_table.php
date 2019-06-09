<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->integer('sell_id');
            $table->integer('buy_id');
            $table->integer('quantity');
            $table->integer('hold_time');
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
        Schema::dropIfExists('sell_logs');
    }
}
