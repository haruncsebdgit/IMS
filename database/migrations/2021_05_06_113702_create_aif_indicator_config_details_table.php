<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAifIndicatorConfigDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aif_indicator_config_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('indicator_config_id');
            $table->unsignedBigInteger('indicator_id')->nullable();
            $table->string('static_indicator_key')->nullable()->comment("Indicator that answer comes from AIF Fund allocation scope");
            $table->string('serial_en')->nullable();
            $table->string('serial_bn')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->foreign('indicator_config_id')->references('id')->on('aif_indicator_configurations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('indicator_id')->references('id')->on('aif_assessment_indicators')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aif_indicator_config_details');
    }
}
