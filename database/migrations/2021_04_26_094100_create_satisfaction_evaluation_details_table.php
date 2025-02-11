<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatisfactionEvaluationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satisfaction_evaluation_details', function (Blueprint $table) {
           
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('satisfaction_id');
            $table->unsignedBigInteger('project_activity_id');
            $table->integer('satisfied_male')->nullable();
            $table->integer('satisfied_female')->nullable();
            $table->integer('very_satisfied_male')->nullable();
            $table->integer('very_satisfied_female')->nullable();
            $table->integer('not_satisfied_male')->nullable();
            $table->integer('not_satisfied_female')->nullable();
            $table->integer('very_dissatisfied_male')->nullable();
            $table->integer('very_dissatisfied_female')->nullable();
            $table->integer('fairly_satisfied_male')->nullable();
            $table->integer('fairly_satisfied_female')->nullable();
           
            $table->timestamps();

            $table->foreign('satisfaction_id')->references('id')->on('satisfaction_evaluations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('project_activity_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('satisfaction_evaluation_details');
    }
}
