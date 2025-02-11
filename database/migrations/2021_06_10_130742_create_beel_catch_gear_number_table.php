<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelCatchGearNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_catch_gear_number', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('beel_catch_id');
            $table->unsignedBigInteger('fishing_gear_id');
            $table->integer('gear_number')->nullable();
            //relationship
            $table->foreign('fishing_gear_id')->references('id')->on('fishing_gear')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('beel_catch_id')->references('id')->on('beel_catch_data')->onUpdate('cascade')->onDelete('restrict');


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
        Schema::dropIfExists('beel_catch_gear_number');
    }
}
