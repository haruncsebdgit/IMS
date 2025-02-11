<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropSeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_season', function (Blueprint $table) {
            $table->unsignedBigInteger('crop_id');
            $table->unsignedBigInteger('season_id');

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
        Schema::dropIfExists('crop_season');
    }
}
