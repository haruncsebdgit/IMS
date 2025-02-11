<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentalAquaPracInstructTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environmental_aqua_prac_instruct', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->bigInteger('environmental_aqua_practice_info_id');
            $table->unsignedBigInteger('parameter_id');
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->foreign('parameter_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('environmental_aqua_prac_instruct');
    }
}
