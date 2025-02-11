<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentalPondParameterInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environmental_pond_parameter_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->bigInteger('pond_quality_id');
            $table->unsignedBigInteger('parameter_id');
            $table->integer('pond_water_cig')->nullable();
            $table->integer('pond_water_non_cig')->nullable();
            $table->integer('taken_actions_cig')->nullable();
            $table->integer('taken_actions_non_cig')->nullable();
            $table->text('taken_actions')->nullable();
            $table->text('measure_before_intervention')->nullable();
            $table->text('measure_after_intervention')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('environmental_pond_parameter_info');
    }
}
