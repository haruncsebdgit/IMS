<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroodDevelopmentFingerlingsProductionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brood_development_fingerlings_production_infos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brood_development_id');
            $table->unsignedBigInteger('fish_species_fingerlings_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('avg_weight_fingerlings')->nullable();
            $table->unsignedBigInteger('total_number')->nullable();
            $table->date('production_date')->nullable();
            $table->date('sale_start_date')->nullable();
            
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
        Schema::dropIfExists('brood_development_fingerlings_production_infos');
    }
}
