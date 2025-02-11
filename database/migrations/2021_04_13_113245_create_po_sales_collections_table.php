<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoSalesCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_sales_collections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('po_sales_id')->comment('Priamry key of PO sales table');
            $table->unsignedBigInteger('cig_id')->nullable()->comment('Priamry key of cigs table');
            $table->unsignedBigInteger('seller_name_id')->nullable()->comment('Priamry key of cig member table');
            $table->string('seller_name_other', 300)->nullable()->comment('Priamry key of cig member table');
            $table->unsignedBigInteger('item_id')->comment('Items id from common labels');
            $table->integer('grade');
            $table->decimal('unit_price', $precision = 8, $scale = 2);
            $table->decimal('total_quantity', $precision = 8, $scale = 2);
            $table->decimal('total_sales_price', $precision = 8, $scale = 2);
            $table->decimal('market_unit_price', $precision = 8, $scale = 2);
            $table->decimal('ccmc_processing_cost', $precision = 8, $scale = 2);
            $table->timestamps();
            $table->foreign('po_sales_id')->references('id')->on('po_sales')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('seller_name_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('po_sales_collections');
    }
}
