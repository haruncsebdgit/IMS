<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_days', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_region_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('financial_year_id');

            $table->unsignedBigInteger('cig_id')->nullable()->comment('DOF,DAE');
            $table->unsignedBigInteger('cig_member_id')->nullable()->comment('DAE,DOF');
            $table->unsignedBigInteger('demonstrated_technology_id')->nullable()->comment('DOF,DAE');

            $table->date('dof_field_day_date')->nullable();
            $table->string('dof_presence')->nullable()->comment('DOF');
            $table->string('dof_area')->nullable()->comment('DOF');
            $table->decimal('dof_participant_male',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('dof_participant_female',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('dof_participant_ethnic',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('dof_toal_participant',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            
            $table->date('dae_reporting_date')->nullable()->comment('DAE');
            $table->decimal('dae_number_of_present_officer',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_number_of_representative_officer',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_number_of_farmer_interested_technology',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->longText('dae_remarks')->nullable()->comment('For DAE');

            $table->decimal('dae_number_of_cig_male',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_number_of_cig_female',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_number_of_non_cig_male',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_number_of_non_cig_female',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_number_of_ethnic_male',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
            $table->decimal('dae_number_of_ethnic_female',  $precision = 8, $scale = 2)->nullable()->comment('DAE');
    
            
            
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->timestamps();

            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('demonstrated_technology_id')->references('id')->on('technologies')->onUpdate('cascade')->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('field_days');
    }
}
