<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImpactAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aif_impact_assessments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('organogram_id')->nullable()->comment("Office/Organogram Id");
            $table->unsignedBigInteger('project_id')->nullable()->comment("Projects Id");
            $table->unsignedBigInteger('assessment_config_id');
            $table->unsignedBigInteger('sub_project_id');
            $table->unsignedBigInteger('sub_project_type_id');
            $table->string('fund_type');
            $table->date('date_of_assessment');
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organogram_id')->references('id')->on('organograms')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('assessment_config_id')->references('id')->on('aif_indicator_configurations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('sub_project_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('sub_project_id')->references('id')->on('aif_fund_allocations')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('aif_impact_assessments');
    }
}
