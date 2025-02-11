<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelOtherFishingSampleDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_other_fishing_sample_data', function (Blueprint $table) {    
            $table->engine = 'InnoDB';   
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('beel_catch_id');
            $table->unsignedBigInteger('species_name')->nullable();
            $table->integer('day_number')->nullable();
            $table->integer('estimated_total_catch')->nullable();
            $table->integer('sample_total')->nullable();
            $table->integer('total_catch_for_season')->nullable();
            //relationship
            $table->foreign('beel_catch_id')->references('id')->on('beel_catch_data')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('species_name')->references('id')->on('fish_species')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beel_other_fishing_sample_data');
    }
}
