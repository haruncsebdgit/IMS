<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvItemTransferInformationItemInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_item_transfer_information_item_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transfer_item_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->integer('item_status_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('serial')->nullable();          
            $table->string('fixed_asset_id')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('inv_item_transfer_information_item_information');
    }
}
