<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations_user_answers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('performance_evaluation_id');
            $table->unsignedBigInteger('indicator_id');
            $table->unsignedBigInteger('answer_id');
            $table->foreign('performance_evaluation_id')->references('id')->on('performance_evaluations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('indicator_id')->references('id')->on('indicators')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('answer_id')->references('id')->on('indicator_answers')->onUpdate('cascade')->onDelete('restrict');
            
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
        Schema::dropIfExists('evaluations_user_answers');
    }
}
