<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTotalCostColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('micro_plan_technology_trainings', function (Blueprint $table) {
            $table->renameColumn('total_cost', 'cost');
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
            $table->renameColumn('cost', 'total_cost');
        });
    }
}
