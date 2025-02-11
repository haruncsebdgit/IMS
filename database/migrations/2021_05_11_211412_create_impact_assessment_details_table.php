<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpactAssessmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aif_impact_assessment_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('assessment_id');
            $table->unsignedBigInteger('assess_config_details_id');
            $table->string('assessment_response', 300);
            $table->timestamps();
            $table->foreign('assessment_id')->references('id')->on('aif_impact_assessments')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('assess_config_details_id')->references('id')->on('aif_indicator_config_details')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aif_impact_assessment_details');
    }
}
