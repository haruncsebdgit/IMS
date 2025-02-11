<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypeReportingMonthToFiacFunctionalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiac_functionalities', function (Blueprint $table) {
            $table->string('reporting_month')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiac_functionalities', function (Blueprint $table) {
            $table->date('reporting_month')->nullable()->change();
        });
    }
}
