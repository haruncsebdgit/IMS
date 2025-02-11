<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImplementedVisitInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('implemented_visit_info', function (Blueprint $table) {
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
            $table->string('visited_date')->nullable();
            $table->string('visited_place')->nullable();
            $table->unsignedBigInteger('exhibited_technology_id')->nullable();
            $table->integer('number_of_female_farmer')->nullable();
            $table->integer('num_of_farmer_interseted_about_exhibited_tech')->nullable();

            //DLS
            $table->integer('dls_num_of_farmer_participated')->nullable();
            $table->integer('dls_num_of_ethnic_farmer_participated')->nullable();
            $table->integer('dls_num_of_ethnic_female_farmer_participated')->nullable();
            $table->integer('dls_num_of_ceal_staff_officer_participated')->nullable();
            $table->integer('dls_num_of_female_ceal_staff_officer_participated')->nullable();

            //DAE
            $table->unsignedBigInteger('dae_crop_id')->nullable();
            $table->unsignedBigInteger('dae_season_id')->nullable();
            $table->text('dae_justification_for_select_place')->nullable();
            $table->integer('dae_num_of_male_farmer_participated')->nullable();
            $table->integer('dae_num_of_farmer_know_about_tech')->nullable();

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
         
            // demonstrated_technology_id  already used for dof 
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dae_crop_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dae_season_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('exhibited_technology_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');



            
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
        Schema::dropIfExists('implemented_visit_info');
    }
}
