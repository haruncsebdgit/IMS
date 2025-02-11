<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptingTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adopting_technologies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('adopting_farmer_id');
            $table->unsignedBigInteger('technology_id');

            $table->foreign('adopting_farmer_id')->references('id')->on('adopting_farmers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('technology_id')->references('id')->on('technologies')->onUpdate('cascade')->onDelete('restrict');
            
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
        Schema::dropIfExists('adopting_technologies');
    }
}
