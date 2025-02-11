<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiacFunctionalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiac_functionalities', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->text('fiac_id')->nullable();
            $table->unsignedBigInteger('financial_years_id');
            $table->text('ceal_id')->nullable();
            $table->date('reporting_month')->nullable();
            $table->bigInteger('farmer_advised_at_fiac')->nullable();
            $table->bigInteger('female_farmer_advised_at_fiac')->nullable();
            $table->bigInteger('ethnic_farmer_advised_at_fiac')->nullable();
            $table->bigInteger('ethnic_female_farmer_advised_at_fiac')->nullable();
            $table->bigInteger('posters_distributed_from_fiac')->nullable();
            $table->bigInteger('leaflet_distributed_from_fiac')->nullable();
            $table->bigInteger('number_of_video_conferencing_or_call_farmers')->nullable();
            $table->bigInteger('booklets_distributed_from_fiac')->nullable();

            // $table->text('service')->nullable();
            // $table->bigInteger('number_of_farmer')->nullable();

            // $table->bigInteger('created_by')->unsigned()->comment('author');
            // $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
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
        Schema::dropIfExists('fiac_functionalities');
    }
}
