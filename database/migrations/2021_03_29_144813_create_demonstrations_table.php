<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemonstrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demonstrations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('financial_year_id');

            $table->unsignedBigInteger('cig_id')->nullable()->comment('DOF,DAE');
            $table->unsignedBigInteger('cig_member_id')->nullable()->comment('DAE,DLS');
            $table->unsignedBigInteger('demonstrated_technology_id')->nullable()->comment('DOF,DAE');

            //Field for DOF Organization
            $table->enum('dof_input_type', ['demonstration', 'adapter'])->nullable()->default(null)->comment('DOF');
            $table->enum('dof_type', ['cig', 'non-cig'])->default('cig')->nullable()->default(null)->comment('DOF');
            $table->string('dof_farmer_name', 300)->nullable()->comment('DOF');
            $table->decimal('dof_demonstration_pond_area',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->unsignedBigInteger('dof_previous_year_technology_id')->nullable()->comment('DOF');
            $table->decimal('dof_previous_year_yield')->nullable()->comment('DOF');
            // cig_member_detail_id multiple data
            $table->unsignedBigInteger('dof_in_2016_17_used_technology_id')->nullable()->comment('DOF');
            $table->decimal('dof_yield_of_2016_17')->nullable()->comment('DOF');

            //Field for DLS Organization
            $table->string('dls_demonstration_title', 300)->nullable()->comment('DLS');
            $table->unsignedBigInteger('dls_technology_type_id')->nullable()->comment('DLS');
            $table->string('dls_size_of_demonstration', 300)->nullable()->comment('DLS');
            $table->unsignedBigInteger('dls_technology_demonstrated_id')->nullable()->comment('DLS');
            $table->date('dls_demo_start_date')->nullable()->comment('DLS');
            $table->date('dls_demo_end_date')->nullable()->comment('DLS');
            $table->string('dls_duration',50)->nullable()->comment('DLS');
            $table->decimal('dls_demo_yield',  $precision = 8, $scale = 2)->nullable()->comment('DLS');
            $table->unsignedBigInteger('dls_demo_yield_unit')->nullable()->comment('DLS');
            $table->decimal('dls_before_demo_yield',  $precision = 8, $scale = 2)->nullable()->comment('DLS');
            $table->unsignedBigInteger('dls_before_demo_yield_unit')->nullable()->comment('DLS');
            $table->date('dls_field_day_date')->nullable()->comment('DLS');
            $table->decimal('dls_farmer_attended',  $precision = 8, $scale = 2)->nullable()->comment('DLS');
            $table->decimal('dls_non_cig_farmer_attended',  $precision = 8, $scale = 2)->nullable()->comment('DLS');
            $table->decimal('dls_ethnic_farmer_attended',  $precision = 8, $scale = 2)->nullable()->comment('DLS');
            $table->decimal('dls_female_cig_farmer_attended',  $precision = 8, $scale = 2)->nullable()->comment('DLS');
            $table->decimal('dls_female_non_cig_farmer_attended',  $precision = 8, $scale = 2)->nullable()->comment('DLS');
            $table->decimal('dls_female_ethnic_farmer_attended',  $precision = 8, $scale = 2)->nullable()->comment('DLS');
          
            //Field for DAE Organization
            //cig_id  already used for dof
            $table->unsignedBigInteger('dae_season_id')->nullable()->comment('DAE');
            $table->date('dae_primary_reporting_date')->nullable()->comment('DAE');
         
            // demonstrated_technology_id  already used for dof 
            $table->unsignedBigInteger('dae_crope_id')->nullable()->comment('DAE');
            $table->string('dae_species',300)->nullable()->comment('DAE');
            $table->decimal('dae_area',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->date('dae_plantation_date')->nullable()->comment('DAE');
            $table->string('dae_responsible_sao_name',300)->nullable()->comment('DAE');
            $table->string('dae_sao_mobile',13)->nullable()->comment('DAE');
            $table->date('dae_final_reporting_date')->nullable()->comment('DAE');
            $table->date('dae_crop_harvesting_date')->nullable()->comment('DAE');
            $table->decimal('dae_total_harvest',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_production_cost',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_total_product_market_value',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->string('dae_profit_loss')->nullable()->comment('DAE');
            $table->decimal('dae_production_of_control_perter',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->text('dae_remarks')->nullable()->comment('For DAE');
     

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('demonstrated_technology_id')->references('id')->on('technologies')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dof_previous_year_technology_id')->references('id')->on('technologies')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dof_in_2016_17_used_technology_id')->references('id')->on('technologies')->onUpdate('cascade')->onDelete('restrict');
            
            $table->foreign('dls_technology_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dls_technology_demonstrated_id')->references('id')->on('technologies')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dls_demo_yield_unit')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dls_before_demo_yield_unit')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dae_season_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('dae_crope_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');

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
        Schema::dropIfExists('demonstrations');
    }
}
