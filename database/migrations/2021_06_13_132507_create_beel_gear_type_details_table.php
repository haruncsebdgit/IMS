<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelGearTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_gear_type_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';   
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('beel_catch_id');
            $table->unsignedBigInteger('fishing_gear_type_id');
            $table->integer('total_unit')->nullable();
            $table->integer('sample_unit')->nullable();
            $table->double('raising_factor',10,2)->nullable();
            //relationship
            $table->foreign('fishing_gear_type_id')->references('id')->on('fishing_gear')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('beel_gear_type_details');
    }
}
