<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelDetailsStockingForImpactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_details_stocking_for_impact', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('beel_detail_id')->nullable();
            $table->unsignedBigInteger('fish_species_id')->nullable();
            $table->integer('number_nursery')->nullable();
            $table->integer('weight_nursery')->nullable();
            $table->integer('number_gov_project')->nullable();
            $table->integer('weight_gov_project')->nullable();
            $table->integer('number_beneficiary')->nullable();
            $table->integer('weight_beneficiary')->nullable();
            $table->integer('number_total_amount')->nullable();
            $table->integer('weight_total_amount')->nullable();
             //foreign
             $table->foreign('beel_detail_id')->references('id')->on('beel_details')->onUpdate('cascade')->onDelete('restrict');
             $table->foreign('fish_species_id')->references('id')->on('fish_species')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('beel_details_stocking_for_impact');
    }
}
