<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToMicroPlanTechnologyTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('micro_plan_technology_trainings', function (Blueprint $table) {
            $table->unsignedBigInteger('title_of_activity')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('micro_plan_technology_trainings', function (Blueprint $table) {
            //
        });
    }
}
