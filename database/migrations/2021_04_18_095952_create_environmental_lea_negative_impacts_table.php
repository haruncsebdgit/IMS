<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentalLeaNegativeImpactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environmental_lea_negative_impacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->bigInteger('lea_information_id');
            $table->unsignedBigInteger('negative_impact_id');
            $table->text('action_for_resolve_problem')->nullable();
            $table->timestamps();

            $table->foreign('negative_impact_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('environmental_lea_negative_impacts');
    }
}
