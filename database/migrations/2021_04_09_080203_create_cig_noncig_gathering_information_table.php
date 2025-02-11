<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCigNoncigGatheringInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cig_noncig_gathering_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id');
            $table->unsignedBigInteger('cig_id');
            $table->string('technology_shared');
            $table->string('number_of_folder')->nullable();
            $table->string('financial_year')->nullable();
            $table->string('gathering_place')->nullable();
            $table->decimal('number_of_cig_farmer_attended' , $precision = 12, $scale = 2)->nullable();
            $table->decimal('number_of_noncig_farmer_attended', $precision = 12, $scale = 2)->nullable();
            $table->decimal('number_of_ethnic_farmer_attended', $precision = 12, $scale = 2)->nullable();
            $table->decimal('number_of_female_cig_farmer_attended', $precision = 12, $scale = 2)->nullable();
            $table->decimal('number_of_female_noncig_farmer_attended', $precision = 12, $scale = 2)->nullable();
            $table->decimal('number_of_female_ethnic_farmer_attended' , $precision = 12, $scale = 2)->nullable();
            $table->date('gathering_date')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('cig_noncig_gathering_information');
    }
}
