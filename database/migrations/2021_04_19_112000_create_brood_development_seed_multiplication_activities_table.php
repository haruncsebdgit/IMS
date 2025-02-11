<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroodDevelopmentSeedMultiplicationActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brood_development_seed_multiplication_activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();      
            $table->date('entry_date');
            $table->unsignedBigInteger('seed_multiplication_farm_name');
            $table->unsignedBigInteger('number_of_germplasm_recieved')->nullable();
            $table->unsignedBigInteger('germplasm_recieved_from')->nullable();
            $table->date('germplasm_recieved_date')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            
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
        Schema::dropIfExists('brood_development_seed_multiplication_activities');
    }
}
