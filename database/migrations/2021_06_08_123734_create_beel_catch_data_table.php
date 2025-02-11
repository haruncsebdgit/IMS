<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelCatchDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_catch_data', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('organogram_id')->nullable();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('beel_id')->nullable();
            $table->date('entry_date')->nullable();
            $table->unsignedBigInteger('financial_year_id')->nullable();
            $table->integer('water_in_rainy_season');
            $table->integer('water_in_dry_season')->nullable();
            $table->integer('water_in_winter_season')->nullable();
            $table->integer('average_depth_in_rainy')->nullable();
            $table->integer('average_depth_in_dry')->nullable();
            $table->integer('average_depth_in_winter')->nullable();
            $table->integer('waterbody_link_id')->nullable();
            $table->integer('leasing_arrangement_id')->nullable();
            $table->integer('floating_vegetation_covered')->nullable();
            $table->integer('submerged_vegetation_covered')->nullable();
            $table->integer('development_work_id')->nullable();
            $table->integer('fry_stocking_by_id')->nullable();
            $table->date('fishing_period_from')->nullable();
            $table->date('fishing_period_to')->nullable();
            $table->enum('fishing_method_id', ['other fishing', 'katta fishing', 'both']);
            $table->integer('katta_number')->nullable();
            $table->integer('fisherman_number')->nullable();
            $table->integer('boat_number')->nullable();
            $table->enum('sample_day_fishing_type_id', ['other fishing', 'katta fishing', 'both']);
            $table->date('sample_date')->nullable();
            $table->string('investigator_name')->nullable();
            $table->integer('production_per_hectare')->nullable();
            $table->string('signatory_user')->nullable();

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            // Relationship
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organogram_id')->references('id')->on('organograms')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('beel_catch_data');
    }
}
