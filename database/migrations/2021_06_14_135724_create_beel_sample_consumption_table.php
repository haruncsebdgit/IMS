<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelSampleConsumptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        Schema::create('beel_sample_consumption', function (Blueprint $table) {
            $table->engine = 'InnoDB';   
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('beel_catch_id');
            $table->unsignedBigInteger('species_name_id')->nullable();
            $table->text('marketplace')->nullable();
            $table->integer('consumption')->nullable();
            $table->integer('fish_drying')->nullable();
            $table->integer('sold_quantity')->nullable();
            $table->integer('unit_price')->nullable();
            $table->integer('total_price')->nullable();
            //relationship
            $table->foreign('beel_catch_id')->references('id')->on('beel_catch_data')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('species_name_id')->references('id')->on('fish_species')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beel_sample_consumption');
    }
}
