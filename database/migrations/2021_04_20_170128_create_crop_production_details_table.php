<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropProductionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_production_details', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('crop_production_id');
            $table->unsignedBigInteger('crop_id');
            $table->unsignedBigInteger('season_id')->nullable();
            

            $table->decimal('amount_of_land')->nullable();
            $table->decimal('total_production')->nullable();
            $table->decimal('production')->nullable();
            $table->string('name_of_main_varieties')->nullable();

            $table->foreign('crop_production_id')->references('id')->on('crop_productions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('crop_id')->references('id')->on('crops')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('season_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crop_production_details');
    }
}
