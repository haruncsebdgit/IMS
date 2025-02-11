<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('training_schedule_id');
            $table->unsignedBigInteger('training_venue_id');
            $table->unsignedBigInteger('training_organizer_id');
          

            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->timestamps();

            $table->foreign('training_schedule_id')->references('id')->on('training_schedules')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('training_venue_id')->references('id')->on('training_venue_info')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('training_organizer_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_details');
    }
}
