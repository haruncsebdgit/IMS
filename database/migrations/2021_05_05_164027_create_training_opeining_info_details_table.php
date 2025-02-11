<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingOpeiningInfoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_opeining_info_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('training_opening_id');
            $table->unsignedBigInteger('training_title_id');
            $table->integer('training_duration')->nullable();
            $table->integer('number_of_batch')->nullable();
            $table->integer('participant_per_batch')->nullable();
            $table->integer('no_of_total_participants')->nullable();
            $table->integer('no_of_female_participants')->nullable();
            $table->integer('no_of_male_participants')->nullable();
            $table->integer('total_ethnic_participants')->nullable();
            $table->integer('total_ethnic_female_participants')->nullable();
            $table->integer('total_client_days')->nullable();

            //relationship
            $table->foreign('training_title_id')->references('id')->on('training_titles')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('training_opening_id')->references('id')->on('training_opening_info')->onUpdate('cascade')->onDelete('restrict');

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
        Schema::dropIfExists('training_opeining_info_details');
    }
}
