<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectProgressSummaryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_progress_summary_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('project_progress_id')
                    ->constrained('project_progress_summary')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('activity_id')
                    ->nullable()
                    ->constrained('project_progress_activities')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->integer('total_cumu_prog_incep_to_june');
            $table->integer('female_cumu_prog_incep_to_june');
            $table->integer('total_prog_july21_21dec');
            $table->integer('female_prog_july21_21dec');
            $table->integer('total_prog_jan22_22jun');
            $table->integer('female_prog_jan22_22jun');
            $table->integer('total_prog_jul22_22dec');
            $table->integer('female_prog_jul22_22dec');
            $table->integer('total_prog_jan23_23jun');
            $table->integer('female_prog_jan23_23jun');
            $table->integer('total_cumu_prog_incep_to_23june');
            $table->integer('female_cumu_prog_incep_to_23june');
            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
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
        Schema::dropIfExists('project_progress_summary_details');
    }
}
