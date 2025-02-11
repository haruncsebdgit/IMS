<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentalPondWaterQualityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environmental_pond_water_quality', function (Blueprint $table) {
            $table->engine = 'InnoDB';
                    $table->charset = 'utf8mb4';
                    $table->collation = 'utf8mb4_unicode_ci';
                    $table->bigIncrements('id');
                    $table->unsignedBigInteger('division_id');
                    $table->unsignedBigInteger('district_id');
                    $table->unsignedBigInteger('upazila_id');
                    $table->unsignedBigInteger('union_id')->nullable();
                    $table->unsignedBigInteger('organization_id');
                    $table->unsignedBigInteger('financial_year_id')->nullable();
                    $table->integer('total_union')->nullable();
                    $table->integer('total_cig')->nullable();
                    $table->integer('total_demo_project')->nullable();
        
                   
        
                    $table->bigInteger('created_by')->unsigned()->comment('author');
                    $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
                 
                    //foreign relations
                    $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
                    $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
                    $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
                    $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
                    $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
                    $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
        
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
        Schema::dropIfExists('environmental_pond_water_quality');
    }
}
