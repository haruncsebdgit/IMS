<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroodDevelopmentReceivedInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brood_development_received_infos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brood_development_id');
            $table->unsignedBigInteger('fish_species_id');
            $table->unsignedBigInteger('brood_received_male')->nullable();
            $table->unsignedBigInteger('brood_received_female')->nullable();
            $table->unsignedBigInteger('brood_received_total')->nullable();
            $table->unsignedBigInteger('brood_received_from_id')->nullable();
            $table->date('received_date')->nullable();
            $table->unsignedBigInteger('avg_weight')->nullable();
            $table->unsignedBigInteger('avg_size')->nullable();
            $table->date('probable_maturation_time')->nullable();
            
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
        Schema::dropIfExists('brood_development_received_infos');
    }
}
