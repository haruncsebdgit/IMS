<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationCampaignInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccination_campaign_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id');
            $table->string('financial_year')->nullable();
            $table->unsignedBigInteger('cig_id')->nullable();
            $table->date('campaign_date')->nullable();
            $table->string('campaign_place')->nullable();
            $table->unsignedBigInteger('number_of_farmer_benefited')->nullable();
            $table->unsignedBigInteger('number_of_female_farmer_benefited')->nullable();
            $table->unsignedBigInteger('number_of_ethnic_farmer_benefited')->nullable();
            $table->unsignedBigInteger('number_of_ethnic_female_farmer_benefited')->nullable();
            $table->unsignedBigInteger('number_of_folder')->nullable();
            $table->string('buffalo_fmd')->nullable();
            $table->string('anthrax')->nullable();
            $table->string('bq')->nullable();
            $table->string('hs')->nullable();
            $table->string('ppr')->nullable();
            $table->string('goat_fmd')->nullable();
            $table->string('goat_pox')->nullable();
            $table->string('nd')->nullable();
            $table->string('fowl_pox')->nullable();
            $table->string('duck_plague')->nullable();
            $table->string('duck_cholera')->nullable();
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
        Schema::dropIfExists('vaccination_campaign_information');
    }
}
