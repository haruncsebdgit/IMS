<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiacFunctionalityEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiac_functionality_equipments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fiac_functionality_id')->nullable();
            $table->unsignedBigInteger('equipment_id')->nullable();
            $table->decimal('users', $precision = 8, $scale = 2)->nullable();
            $table->decimal('total_equipment', $precision = 8, $scale = 2)->nullable();
            
            $table->foreign('fiac_functionality_id')->references('id')->on('fiac_functionalities')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('fiac_functionality_equipments');
    }
}
