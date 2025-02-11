<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoSalesDetailsDlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_sales_details_dls', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('po_sales_id')->comment('Priamry key of PO sales table');
            $table->unsignedBigInteger('product_type_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('unit_price', $precision = 8, $scale = 2);
            $table->decimal('total_quantity', $precision = 8, $scale = 2);
            $table->decimal('total_sales_price', $precision = 8, $scale = 2);
            $table->decimal('number_of_product', $precision = 8, $scale = 2);
            $table->decimal('number_of_sale', $precision = 8, $scale = 2);
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
        Schema::dropIfExists('po_sales_details_dls');
    }
}
