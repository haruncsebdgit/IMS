<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelActivitiesDetailsIndegenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_activities_details_indegenus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('activity_detail_id')->nullable()->comment("beel_activities_details table");
            $table->unsignedBigInteger('fish_species_id')->nullable()->comment("fish_species table");
            $table->integer('stocking_number_fingerling')->nullable();
            $table->integer('average_individual_size')->nullable();
            $table->integer('average_individual_weight')->nullable();
            $table->integer('amount_fingerling_stocked')->nullable();
   
            $table->foreign('activity_detail_id')->references('id')->on('beel_activities_details')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('fish_species_id')->references('id')->on('fish_species')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('beel_activities_details_indegenus');
    }
}
