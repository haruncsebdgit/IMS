<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoilHealthDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soil_health_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('soil_health_id');
            $table->unsignedBigInteger('cig_id')->nullable()->comment('DLS,DOF,DAE');
            $table->unsignedBigInteger('cig_member_id')->nullable()->comment('DLS,DOF,DAE');
            $table->string('organic_matter')->nullable()->comment('DLS');
            $table->string('ph')->nullable()->comment('DLS');

            $table->timestamps();

            $table->foreign('soil_health_id')->references('id')->on('soil_healths')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soil_health_details');
    }
}
