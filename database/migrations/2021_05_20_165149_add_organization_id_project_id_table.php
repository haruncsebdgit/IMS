<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganizationIdProjectIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = [
            'training_categories', 'implemented_visit_info',
            'environmental_pond_water_quality', 'environmental_waste_management', 'grievance_redress_info',
            'environmental_aqua_practice_info', 'environmental_lea_information', 'soil_healths', 'indicator_categories',
            'indicator_sub_categories', 'indicator_setups', 'field_days', 'adopting_farmers', 'satisfaction_evaluations',
            'farmers', 'demonstrations', 'demo_productions', 'monitoring_indicators'
        ];
        foreach ($table as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->unsignedBigInteger('organogram_id')->nullable()->after('organization_id');
                $table->unsignedBigInteger('project_id')->nullable()->after('organogram_id');

                $table->foreign('organogram_id')->references('id')->on('organograms')->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = [
            'training_categories', 'implemented_visit_info',
            'environmental_pond_water_quality', 'environmental_waste_management', 'grievance_redress_info',
            'environmental_aqua_practice_info', 'environmental_lea_information', 'soil_healths', 'indicator_categories',
            'indicator_sub_categories', 'indicator_setups', 'field_days', 'adopting_farmers', 'satisfaction_evaluations',
            'farmers', 'demonstrations', 'demo_productions', 'monitoring_indicators'
        ];
        foreach ($table as $t) {
            Schema::table($t, function (Blueprint $table) {
                Schema::disableForeignKeyConstraints();
                if($table == 'training_categories'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE training_categories DROP constraint training_categories_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE training_categories DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE training_categories DROP constraint training_categories_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE training_categories DROP column project_id;");

                }

                if($table == 'implemented_visit_info'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE implemented_visit_info DROP constraint implemented_visit_info_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE implemented_visit_info DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE implemented_visit_info DROP constraint implemented_visit_info_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE implemented_visit_info DROP column project_id;");

                }

                if($table == 'environmental_pond_water_quality'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_pond_water_quality DROP constraint environmental_pond_water_quality_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_pond_water_quality DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_pond_water_quality DROP constraint environmental_pond_water_quality_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_pond_water_quality DROP column project_id;");

                }

                if($table == 'environmental_waste_management'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_waste_management DROP constraint environmental_waste_management_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_waste_management DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_waste_management DROP constraint environmental_waste_management_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_waste_management DROP column project_id;");

                }

                if($table == 'grievance_redress_info'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE grievance_redress_info DROP constraint grievance_redress_info_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE grievance_redress_info DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE grievance_redress_info DROP constraint grievance_redress_info_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE grievance_redress_info DROP column project_id;");

                }
                
                if($table == 'environmental_aqua_practice_info'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_aqua_practice_info DROP constraint environmental_aqua_practice_info_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_aqua_practice_info DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_aqua_practice_info DROP constraint environmental_aqua_practice_info_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_aqua_practice_info DROP column project_id;");

                }

                if($table == 'environmental_lea_information'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_lea_information DROP constraint environmental_lea_information_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_lea_information DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_lea_information DROP constraint environmental_lea_information_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE environmental_lea_information DROP column project_id;");

                }

                if($table == 'soil_healths'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE soil_healths DROP constraint soil_healths_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE soil_healths DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE soil_healths DROP constraint soil_healths_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE soil_healths DROP column project_id;");

                }

                if($table == 'indicator_categories'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_categories DROP constraint indicator_categories_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_categories DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_categories DROP constraint indicator_categories_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_categories DROP column project_id;");

                }

                if($table == 'indicator_sub_categories'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_sub_categories DROP constraint indicator_sub_categories_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_sub_categories DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_sub_categories DROP constraint indicator_sub_categories_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_sub_categories DROP column project_id;");

                }

                if($table == 'indicator_setups'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_setups DROP constraint indicator_setups_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_setups DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_setups DROP constraint indicator_setups_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE indicator_setups DROP column project_id;");

                }

                if($table == 'field_days'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE field_days DROP constraint field_days_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE field_days DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE field_days DROP constraint field_days_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE field_days DROP column project_id;");

                }

                if($table == 'adopting_farmers'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE adopting_farmers DROP constraint adopting_farmers_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE adopting_farmers DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE adopting_farmers DROP constraint adopting_farmers_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE adopting_farmers DROP column project_id;");

                }

                if($table == 'satisfaction_evaluations'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE satisfaction_evaluations DROP constraint satisfaction_evaluations_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE satisfaction_evaluations DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE satisfaction_evaluations DROP constraint satisfaction_evaluations_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE satisfaction_evaluations DROP column project_id;");

                }

                if($table == 'farmers'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE farmers DROP constraint farmers_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE farmers DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE farmers DROP constraint farmers_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE farmers DROP column project_id;");

                }

                if($table == 'demonstrations'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE demonstrations DROP constraint demonstrations_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE demonstrations DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE demonstrations DROP constraint demonstrations_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE demonstrations DROP column project_id;");

                }

                if($table == 'demo_productions'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE demo_productions DROP constraint demo_productions_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE demo_productions DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE demo_productions DROP constraint demo_productions_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE demo_productions DROP column project_id;");

                }

                if($table == 'monitoring_indicators'){
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE monitoring_indicators DROP constraint monitoring_indicators_organogram_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE monitoring_indicators DROP column organogram_id;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE monitoring_indicators DROP constraint monitoring_indicators_project_id_foreign;");
                    DB::statement("SET FOREIGN_KEY_CHECKS=0; ALTER TABLE monitoring_indicators DROP column project_id;");
                }
                


                // $table->dropColumn(['organogram_id']);
                // $table->dropColumn(['project_id']);
                Schema::enableForeignKeyConstraints();
            });
        }
    }
}
