<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHatheryNurseriesFishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hathery_nurseries_fishes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hathery_nursery_id');
            $table->unsignedBigInteger('fish_species_id');
            $table->date('fish_available_date');
            $table->timestamps();
            $table->foreign('hathery_nursery_id')->references('id')->on('hathery_nurseries')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('fish_species_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hathery_nurseries_fishes');
    }
}
