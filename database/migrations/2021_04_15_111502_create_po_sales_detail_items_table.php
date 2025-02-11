<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoSalesDetailItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_sales_detail_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('po_sales_detail_id')->comment('Priamry key of PO sales detail table');
            $table->unsignedBigInteger('buyer_trader_id')->nullable()->comment('Priamry key of trader_distributer_buyers table');
            $table->string('new_buyer_trader_name', 300)->nullable();
            $table->unsignedBigInteger('items_id');
            $table->decimal('total_transported_quantity', $precision = 8, $scale = 2);
            $table->decimal('total_sales_quantity', $precision = 8, $scale = 2);
            $table->decimal('damaged_quantity', $precision = 8, $scale = 2)->nullable();
            $table->unsignedBigInteger('exporter_company_id')->nullable();
            $table->unsignedBigInteger('exporter_country_id')->nullable();
            $table->timestamps();
            $table->foreign('po_sales_detail_id')->references('id')->on('po_sales_details')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('buyer_trader_id')->references('id')->on('trader_distributer_buyers')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_sales_detail_items');
    }
}
