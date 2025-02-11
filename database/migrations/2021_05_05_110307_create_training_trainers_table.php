<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_trainers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('training_info_id');
            $table->unsignedBigInteger('trainer_id');
            $table->enum('trainer_type', ['internal', 'external'])->default('internal');
            $table->timestamps();

            $table->foreign('training_info_id')->references('id')->on('training_informations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('trainer_id')->references('id')->on('trainer_information')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_trainers');
    }
}
