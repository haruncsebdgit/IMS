<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiacFunctionalityRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiac_functionality_registers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fiac_functionality_id')->nullable();
            $table->unsignedBigInteger('register_id')->nullable();

            $table->foreign('fiac_functionality_id')->references('id')->on('fiac_functionalities')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('register_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fiac_functionality_registers');
    }
}
