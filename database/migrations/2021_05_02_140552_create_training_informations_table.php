<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_informations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('financial_year_id');
            $table->string('memo_no')->nullable();
            $table->date('memo_date')->nullable();
            $table->unsignedBigInteger('training_type_id')->nullable();
            $table->unsignedBigInteger('training_title_id')->nullable();
            $table->integer('training_duration')->nullable();
            $table->integer('total_number_of_trainee')->nullable();
            $table->integer('batch_no')->nullable();
            $table->enum('training_venue_type', ['residential ', 'non-residential'])->nullable()->default(null);
            // $table->date('training_start_date')->nullable();
            // $table->date('training_end_date')->nullable();
            $table->decimal('training_expenditure', $precision = 8, $scale = 2)->nullable();
            $table->integer('max_time_participate_in_same_training')->nullable();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->date('training_start_date')->nullable();
            $table->date('training_end_date')->nullable();

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('training_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('season_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('training_title_id')->references('id')->on('training_titles')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_informations');
    }
}
