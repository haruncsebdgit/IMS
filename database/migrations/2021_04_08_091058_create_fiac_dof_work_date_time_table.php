<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiacDofWorkDateTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiac_dof_work_date_time', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fiac_id');
            $table->unsignedBigInteger('working_day_id');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->timestamps();

            $table->foreign('working_day_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fiac_dof_work_date_time');
    }
}
