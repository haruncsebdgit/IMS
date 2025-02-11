<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFishStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fish_stock_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cig_production_id');
            $table->unsignedBigInteger('fish_species_name_id');
            $table->integer('total_number_of_stocked');
            $table->decimal('size', $precision = 8, $scale = 2)->nullable();
            $table->date('stocking_date')->nullable();
            $table->integer('pond_number')->nullable();
            $table->foreign('cig_production_id')->references('id')->on('cig_productions')->onUpdate('cascade')->onDelete('restrict');
            
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
        Schema::dropIfExists('fish_stock_details');
    }
}
