<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingTrainersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_trainer_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('training_info_id');
            $table->unsignedBigInteger('trainer_type_id');
        
            $table->timestamps();

            $table->foreign('training_info_id')->references('id')->on('training_informations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('trainer_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_trainer_details');
    }
}
