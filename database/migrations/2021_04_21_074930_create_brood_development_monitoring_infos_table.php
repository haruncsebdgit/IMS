<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroodDevelopmentMonitoringInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brood_development_monitoring_infos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brood_development_id');
            $table->unsignedBigInteger('fish_species_monitoring_id');   
            $table->unsignedBigInteger('brood_male')->nullable();
            $table->unsignedBigInteger('brood_female')->nullable();
            $table->unsignedBigInteger('brood_total')->nullable();
            $table->unsignedBigInteger('avg_weight_monitoring')->nullable();
            $table->unsignedBigInteger('avg_size_monitoring')->nullable();
            $table->date('reporting_date')->nullable();
            $table->date('probable_maturation_time_monitoring')->nullable();
            
            
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
        Schema::dropIfExists('brood_development_monitoring_infos');
    }
}
