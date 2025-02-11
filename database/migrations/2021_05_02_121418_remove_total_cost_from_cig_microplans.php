<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTotalCostFromCigMicroplans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cig_microplans', function (Blueprint $table) {
            $table->dropColumn('total_cost');
            $table->dropColumn('identified_problem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cig_microplans', function (Blueprint $table) {
            
            $table->text('total_cost');
            $table->string('identified_problem');
        });
    }
}
