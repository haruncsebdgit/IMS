<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentalAquaPracticeInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environmental_aqua_practice_info', function (Blueprint $table) {
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
            $table->unsignedBigInteger('cig_id')->nullable();
            $table->string('programme_date')->nullable();
            $table->bigInteger('total_male_participant')->nullable();
            $table->bigInteger('total_female_participant')->nullable();
            $table->string('instructor_name')->nullable();
            $table->string('instructor_designation')->nullable();


            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
         
            // foreign keys
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');


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
        Schema::dropIfExists('environmental_aqua_practice_info');
    }
}
