<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelBaselinesFishingGearDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_baselines_fishing_gear_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('beel_baseline_id');
            $table->unsignedBigInteger('fishing_gear_id');

            //foreign
            $table->foreign('beel_baseline_id')->references('id')->on('beel_baselines')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('fishing_gear_id')->references('id')->on('fishing_gear')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('beel_baselines_fishing_gear_details');
    }
}
