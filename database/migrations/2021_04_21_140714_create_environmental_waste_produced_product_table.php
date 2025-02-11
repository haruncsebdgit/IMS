<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentalWasteProducedProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environmental_waste_produced_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->bigInteger('waste_management_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('produced_unit_id')->nullable();
            $table->unsignedBigInteger('used_unit_id')->nullable();
            $table->unsignedBigInteger('sold_unit_id')->nullable();
            $table->integer('qt_produced')->nullable();
            $table->integer('qt_used')->nullable();
            $table->integer('qt_sold')->nullable();
            $table->string('reporting_date')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('produced_unit_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('used_unit_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('sold_unit_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('environmental_waste_produced_product');
    }
}
