<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelDetailsProductionForImpactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_details_production_for_impact', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('beel_detail_id')->nullable();
            $table->unsignedBigInteger('fish_species_id')->nullable();
            $table->integer('stocked_amount_number')->nullable();
            $table->integer('stocked_amount_weight')->nullable();
            $table->integer('baseline_total_production')->nullable();
            $table->integer('baseline_unit_production')->nullable();
            $table->integer('annual_assessment_year')->nullable();
            $table->integer('increase_weight')->nullable();
            $table->integer('increase_percentage')->nullable();
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
        Schema::dropIfExists('beel_details_production_for_impact');
    }
}
