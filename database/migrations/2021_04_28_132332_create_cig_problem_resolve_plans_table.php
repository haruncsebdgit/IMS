<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCigProblemResolvePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cig_problem_resolve_plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cig_id')->nullable();
            $table->string('name_of_task')->nullable();
            $table->string('task_details')->nullable();
            $table->unsignedBigInteger('area')->nullable();
            $table->unsignedBigInteger('weight')->nullable();
            $table->string('implementation_time_1')->nullable();
            $table->string('implementation_time_2')->nullable();
            $table->string('expense_of_cig')->nullable();
            $table->string('project_grant')->nullable();
            $table->string('total_expense')->nullable();
            $table->string('responsible')->nullable();
            
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
        Schema::dropIfExists('cig_problem_resolve_plans');
    }
}
