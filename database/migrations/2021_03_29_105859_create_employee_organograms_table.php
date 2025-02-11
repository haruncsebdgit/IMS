<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeOrganogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_organograms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('organogram_id')->unsigned();

            // Relationship
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organogram_id')->references('id')->on('organograms')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_organograms');
    }
}
