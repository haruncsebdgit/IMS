<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelBaselinesFishAquaticDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_baselines_fish_aquatic_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('beel_baseline_id');
            $table->unsignedBigInteger('aquatic_species_id');
            $table->enum('aquatic_type', ['species', 'weed']);

            //foreign
            $table->foreign('beel_baseline_id')->references('id')->on('beel_baselines')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('aquatic_species_id')->references('id')->on('aquatic_species')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('beel_baselines_fish_aquatic_details');
    }
}
