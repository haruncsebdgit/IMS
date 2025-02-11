<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTraderDistributerBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_trader_dis_buyers', function (Blueprint $table) {
            $table->unsignedBigInteger('trader_dis_buyer_id');
            $table->unsignedBigInteger('item_id');
            $table->foreign('trader_dis_buyer_id')->references('id')->on('trader_distributer_buyers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('item_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_trader_dis_buyers');
    }
}
