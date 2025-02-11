<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemonstrationDaeEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demonstration_dae_equipments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('demonstration_id');
            $table->unsignedBigInteger('element_id');
            $table->string('quantity')->nullable();
            $table->unsignedBigInteger('per_unit')->nullable();

            
            $table->foreign('demonstration_id')->references('id')->on('demonstrations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('element_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('per_unit')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
         
            
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
        Schema::dropIfExists('demonstration_dae_equipments');
    }
}
