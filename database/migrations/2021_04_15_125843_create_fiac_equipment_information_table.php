<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiacEquipmentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiac_equipment_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('select_fiac')->nullable();
            $table->unsignedBigInteger('financial_year')->nullable();
            $table->date('entry_date')->nullable();
            $table->unsignedBigInteger('equipment_name')->nullable();
            $table->unsignedBigInteger('number_of_equipment')->nullable();          
            $table->unsignedBigInteger('used_number_of_equipment')->nullable();         
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('fiac_equipment_information');
    }
}
