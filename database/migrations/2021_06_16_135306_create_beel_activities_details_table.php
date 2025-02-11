<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeelActivitiesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beel_activities_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable()->comment("Organization Id");
            $table->unsignedBigInteger('beel_activities_id')->nullable()->comment("beel Activities Id");
            $table->enum('type_of_beel_development_activity', ['stocking', 'nursery', 'santuary', 'habitat','cbfm','gov']);
            $table->integer('gov_investment')->nullable();
            $table->integer('cbo_investment')->nullable();
            $table->integer('total_return')->nullable();
            $table->integer('net_return')->nullable();
            $table->decimal('individual_benefit', $precision = 8, $scale = 2)->nullable();
            $table->text('remarks')->nullable();
            $table->integer('nursery_pond_area_in_ha')->nullable();
            $table->integer('nursery_number_in_days')->nullable();
            $table->integer('nursery_total_no_of_released')->nullable();
            $table->integer('nursery_total_weight_of_released')->nullable();

            $table->enum('santuary_location', ['east-side', 'west-side', 'north-side', 'south-side','middle'])->nullable();
            $table->integer('santuary_area_in_ha')->nullable();
            $table->integer('santuary_max_water_depth_rainy_season')->nullable();
            $table->integer('santuary_min_water_depth_rainy_season')->nullable();
            $table->integer('santuary_mean_depth')->nullable();

            $table->enum('habitat_purpose_for_improvement', ['1', '2', '3'])->nullable()->comment("Beel nursery pond=1, Fish sanctuary area=2, Others=3");;
            $table->enum('habitat_location', ['east-side', 'west-side', 'north-side', 'south-side','middle'])->nullable();
            $table->integer('habitat_area_in_ha')->nullable();
            $table->integer('habitat_max_water_depth_rainy_season')->nullable();
            $table->integer('habitat_min_water_depth_rainy_season')->nullable();
            $table->integer('habitat_mean_depth')->nullable();
            

            $table->date('cbfm_date_from')->nullable();
            $table->integer('cbfm_total_member_in_group')->nullable();
            $table->integer('cbfm_total_female_member_in_group')->nullable();
            $table->tinyInteger('cbfm_is_executive_committee')->nullable()->default(null)->comment('Is there any executive committee');
            $table->integer('cbfm_total_member_in_executive_committee')->nullable();
            $table->integer('cbfm_total_female_member_in_executive_committee')->nullable();



            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('beel_activities_id')->references('id')->on('beel_activities')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('beel_activities_details');
    }
}
