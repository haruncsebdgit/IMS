<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBeelDetailsForImpactAssessmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beel_details', function (Blueprint $table) {

            $table->tinyInteger('is_beel_nursery_for_impact')->nullable()->default(null)->after('habitat_min_depth');
            $table->tinyInteger('is_fingerling_stocking_for_impact')->nullable()->default(null)->after('is_beel_nursery_for_impact');
            $table->tinyInteger('is_fish_sanctuary_for_impact')->nullable()->default(null)->after('is_fingerling_stocking_for_impact');
            $table->tinyInteger('is_habitat_improvement_for_impact')->nullable()->default(null)->after('is_fish_sanctuary_for_impact');
            $table->tinyInteger('is_fishing_code_implementation_for_impact')->nullable()->default(null)->after('is_habitat_improvement_for_impact');

            $table->string('fish_production_for_impact', 10)->nullable()->after('is_fishing_code_implementation_for_impact');
            $table->string('socio_economic_status_for_impact', 10)->nullable()->after('fish_production_for_impact');
            $table->string('women_involvement_for_impact', 10)->nullable()->after('socio_economic_status_for_impact');
            $table->string('biodiversity_and_ecology_for_impact', 10)->nullable()->after('women_involvement_for_impact');
            $table->longText('others_for_impact')->nullable()->after('biodiversity_and_ecology_for_impact');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beel_details', function (Blueprint $table) {
            $table->dropColumn(['others_for_impact']);
            $table->dropColumn(['biodiversity_and_ecology_for_impact']);
            $table->dropColumn(['women_involvement_for_impact']);
            $table->dropColumn(['socio_economic_status_for_impact']);
            $table->dropColumn(['fish_production_for_impact']);
            $table->dropColumn(['is_fishing_code_implementation_for_impact']);
            $table->dropColumn(['is_habitat_improvement_for_impact']);
            $table->dropColumn(['is_fish_sanctuary_for_impact']);
            $table->dropColumn(['is_fingerling_stocking_for_impact']);
            $table->dropColumn(['is_beel_nursery_for_impact']);
        });
    }
}
