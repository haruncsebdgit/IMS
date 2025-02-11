<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelBaselinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_baselines', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('organogram_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('financial_year_id')->nullable();
         
            $table->string('village')->nullable();
            $table->string('mouza')->nullable();
            $table->string('beel_name_en')->nullable();
            $table->string('beel_name_bn')->nullable();
            $table->string('beel_location')->nullable();
            $table->unsignedBigInteger('ownership_type_id')->nullable();
            $table->date('baseline_data_collection_date')->nullable();

            $table->integer('beel_water_area_in_dry_season')->nullable();
            $table->integer('beel_water_area_in_rainy_season')->nullable();
            $table->integer('max_water_depth_in_rainy_season')->nullable();
            $table->integer('min_water_depth_in_dry_season')->nullable();
            $table->integer('mean_depth')->nullable();
            $table->integer('water_body_type')->nullable();
            $table->integer('nature_water_body_type')->nullable();
            $table->integer('existence_of_current')->nullable();

            $table->tinyInteger('is_connected_with_cannel')->default(1);
            $table->tinyInteger('is_connected_with_river')->default(1);
            $table->tinyInteger('is_connected_with_haor_basin')->default(1);
            $table->tinyInteger('is_connected_with_other_beel')->default(1);
            $table->tinyInteger('is_connected_by_sluice_gate')->default(1);
            $table->tinyInteger('is_connected_by_road_embankment')->default(1);

            $table->tinyInteger('is_natural_management')->default(1);
            $table->tinyInteger('is_community_based_fisheries')->default(1);
            $table->tinyInteger('is_aquaculture_by_individual')->default(1);
            $table->tinyInteger('is_leased_out')->default(1);

            $table->tinyInteger('is_any_beneficiary_group')->default(1);
            $table->date('formation_date')->nullable()->default(null);
            $table->integer('total_number_of_member_in_group')->nullable();
            $table->integer('total_number_of_female_member_in_group')->nullable();

            $table->tinyInteger('is_any_executive_committee')->default(1);
            $table->integer('member_in_executive_committee')->nullable();
            $table->integer('female_member_in_executive_committee')->nullable();
            $table->integer('number_of_fish_landing_center')->nullable();

            $table->tinyInteger('is_existing_fish_sanctuary')->default(1);
            $table->string('location_of_place')->nullable();
            $table->integer('area_of_sanctuary')->nullable();
            $table->integer('max_water_depth_rainy_season')->nullable();
            $table->integer('min_water_depth_dry_season')->nullable();
            $table->integer('min_depth')->nullable();

            $table->tinyInteger('is_suitable_establishing_fish_sanctuary')->default(1);
            $table->string('suitable_location_of_place')->nullable();
            $table->integer('suitable_area_of_sanctuary')->nullable();
            $table->integer('suitable_max_water_depth_rainy_season')->nullable();
            $table->integer('suitable_min_water_depth_dry_season')->nullable();
            $table->integer('suitable_min_depth')->nullable();

            $table->tinyInteger('is_require_area_improvement')->default(1);
            $table->string('purpose_of_habitat_improvement')->nullable();
            $table->string('habitat_location_of_place')->nullable();
            $table->integer('habitat_area_of_sanctuary')->nullable();
            $table->integer('habitat_max_water_depth_rainy_season')->nullable();
            $table->integer('habitat_min_water_depth_dry_season')->nullable();
            $table->integer('habitat_min_depth')->nullable();

            

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organogram_id')->references('id')->on('organograms')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('beel_baselines');
    }
}
