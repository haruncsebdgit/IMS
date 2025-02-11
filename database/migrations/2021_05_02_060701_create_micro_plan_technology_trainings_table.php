<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicroPlanTechnologyTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_plan_technology_trainings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('title_of_activity')->nullable();
            $table->unsignedBigInteger('number_of_events')->nullable();
            $table->unsignedBigInteger('unit_cost_per_events')->nullable();
            $table->unsignedBigInteger('total_cost')->nullable();
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
        Schema::dropIfExists('micro_plan_technology_trainings');
    }
}
