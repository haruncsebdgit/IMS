<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoSalesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_sales_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('po_sales_id')->comment('Priamry key of PO sales table');
            $table->unsignedBigInteger('communication_channel_id');
            $table->unsignedBigInteger('marketplace_type_id');
            $table->unsignedBigInteger('transport_mode_id');
            $table->unsignedBigInteger('packaging_process_id');
            $table->string('transport_media', 300);
            $table->timestamps();
            $table->foreign('po_sales_id')->references('id')->on('po_sales')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_sales_details');
    }
}
