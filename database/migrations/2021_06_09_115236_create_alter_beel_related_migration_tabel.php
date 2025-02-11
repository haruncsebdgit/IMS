<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlterBeelRelatedMigrationTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alter_beel_related_migration_tabel', function (Blueprint $table) {
            //drop foreign keys
            DB::statement('ALTER TABLE beel_baselines_fish_aquatic_details DROP FOREIGN KEY beel_baselines_fish_aquatic_details_aquatic_species_id_foreign, DROP FOREIGN KEY beel_baselines_fish_aquatic_details_beel_baseline_id_foreign;');
            DB::statement('ALTER TABLE beel_baselines_fish_production_details DROP FOREIGN KEY beel_baselines_fish_production_details_beel_baseline_id_foreign, DROP FOREIGN KEY beel_baselines_fish_production_details_fish_species_id_foreign;');
            DB::statement('ALTER TABLE beel_baselines_fish_species_details DROP FOREIGN KEY beel_baselines_fish_species_details_beel_baseline_id_foreign, DROP FOREIGN KEY beel_baselines_fish_species_details_fish_species_id_foreign;');
            DB::statement('ALTER TABLE beel_baselines_fishing_gear_details DROP FOREIGN KEY beel_baselines_fishing_gear_details_beel_baseline_id_foreign, DROP FOREIGN KEY beel_baselines_fishing_gear_details_fishing_gear_id_foreign;');
            DB::statement('ALTER TABLE beel_baselines_problems_details DROP FOREIGN KEY beel_baselines_problems_details_beel_baseline_id_foreign;');

            //alter table name
            DB::statement('ALTER TABLE beel_baselines RENAME beel_details');
            DB::statement('ALTER TABLE beel_baselines_fish_aquatic_details RENAME beel_details_fish_aquatics');
            DB::statement('ALTER TABLE beel_baselines_fish_production_details RENAME beel_details_fish_productions');
            DB::statement('ALTER TABLE beel_baselines_fish_species_details RENAME beel_details_fish_species');
            DB::statement('ALTER TABLE beel_baselines_fishing_gear_details RENAME beel_details_fishing_gears');
            DB::statement('ALTER TABLE beel_baselines_problems_details RENAME beel_details_problems');
            //alter column name
            DB::statement('ALTER TABLE beel_details_fish_aquatics CHANGE beel_baseline_id beel_detail_id BIGINT(20) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE beel_details_fish_productions CHANGE beel_baseline_id beel_detail_id BIGINT(20) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE beel_details_fish_species CHANGE beel_baseline_id beel_detail_id BIGINT(20) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE beel_details_fishing_gears CHANGE beel_baseline_id beel_detail_id BIGINT(20) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE beel_details_problems CHANGE beel_baseline_id beel_detail_id BIGINT(20) UNSIGNED NOT NULL');

            DB::statement("ALTER TABLE `beel_details_fish_aquatics` ADD CONSTRAINT `beel_details_fish_aquatics_beel_detail_id_foreign` FOREIGN KEY (`beel_detail_id`) REFERENCES `beel_details`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `beel_details_fish_aquatic_details_aquatic_species_id_foreign` FOREIGN KEY (`aquatic_species_id`) REFERENCES `aquatic_species`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
            DB::statement("ALTER TABLE `beel_details_fish_productions` ADD CONSTRAINT `beel_details_fish_productions_beel_detail_id_foreign` FOREIGN KEY (`beel_detail_id`) REFERENCES `beel_details`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `beel_details_fish_production_details_fish_species_id_foreign` FOREIGN KEY (`fish_species_id`) REFERENCES `fish_species`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
            DB::statement("ALTER TABLE `beel_details_fish_species` ADD CONSTRAINT `beel_details_fish_species_beel_detail_id_foreign` FOREIGN KEY (`beel_detail_id`) REFERENCES `beel_details`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `beel_details_fish_species_details_fish_species_id_foreign` FOREIGN KEY (`fish_species_id`) REFERENCES `fish_species`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
            DB::statement("ALTER TABLE `beel_details_fishing_gears` ADD CONSTRAINT `beel_details_fishing_gears_beel_detail_id_foreign` FOREIGN KEY (`beel_detail_id`) REFERENCES `beel_details`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `beel_details_fishing_gear_details_fishing_gear_id_foreign` FOREIGN KEY (`fishing_gear_id`) REFERENCES `fishing_gear`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
            DB::statement("ALTER TABLE `beel_details_problems` ADD CONSTRAINT `beel_details_problems_beel_detail_id_foreign` FOREIGN KEY (`beel_detail_id`) REFERENCES `beel_details`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
        {   
            
            DB::statement('ALTER TABLE beel_details_fish_aquatics DROP FOREIGN KEY beel_details_fish_aquatics_beel_detail_id_foreign, DROP FOREIGN KEY beel_details_fish_aquatic_details_aquatic_species_id_foreign;');
            DB::statement('ALTER TABLE beel_details_fish_productions DROP FOREIGN KEY beel_details_fish_productions_beel_detail_id_foreign, DROP FOREIGN KEY beel_details_fish_production_details_fish_species_id_foreign;');
            DB::statement('ALTER TABLE beel_details_fish_species DROP FOREIGN KEY beel_details_fish_species_beel_detail_id_foreign, DROP FOREIGN KEY beel_details_fish_species_details_fish_species_id_foreign;');
            DB::statement('ALTER TABLE beel_details_fishing_gears DROP FOREIGN KEY beel_details_fishing_gears_beel_detail_id_foreign, DROP FOREIGN KEY beel_details_fishing_gear_details_fishing_gear_id_foreign;');
            DB::statement('ALTER TABLE beel_details_problems DROP FOREIGN KEY beel_details_problems_beel_detail_id_foreign;');


            //alter column name
            DB::statement('ALTER TABLE beel_details_problems CHANGE beel_detail_id beel_baseline_id BIGINT(20) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE beel_details_fishing_gears CHANGE beel_detail_id beel_baseline_id BIGINT(20) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE beel_details_fish_species CHANGE beel_detail_id beel_baseline_id BIGINT(20) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE beel_details_fish_productions CHANGE beel_detail_id beel_baseline_id BIGINT(20) UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE beel_details_fish_aquatics CHANGE beel_detail_id beel_baseline_id BIGINT(20) UNSIGNED NOT NULL');

        
            //alter table name
            DB::statement('ALTER TABLE beel_details_problems RENAME beel_baselines_problems_details');
            DB::statement('ALTER TABLE beel_details_fishing_gears RENAME beel_baselines_fishing_gear_details');
            DB::statement('ALTER TABLE beel_details_fish_species RENAME beel_baselines_fish_species_details');
            DB::statement('ALTER TABLE beel_details_fish_productions RENAME beel_baselines_fish_production_details');
            DB::statement('ALTER TABLE beel_details_fish_aquatics RENAME beel_baselines_fish_aquatic_details');
            DB::statement('ALTER TABLE beel_details RENAME beel_baselines');

            DB::statement("ALTER TABLE `beel_baselines_problems_details` ADD CONSTRAINT `beel_baselines_problems_details_beel_baseline_id_foreign` FOREIGN KEY (`beel_baseline_id`) REFERENCES `beel_baselines`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
            DB::statement("ALTER TABLE `beel_baselines_fishing_gear_details` ADD CONSTRAINT `beel_baselines_fishing_gear_details_beel_baseline_id_foreign` FOREIGN KEY (`beel_baseline_id`) REFERENCES `beel_baselines`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `beel_baselines_fishing_gear_details_fishing_gear_id_foreign` FOREIGN KEY (`fishing_gear_id`) REFERENCES `fishing_gear`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
            DB::statement("ALTER TABLE `beel_baselines_fish_species_details` ADD CONSTRAINT `beel_baselines_fish_species_details_beel_baseline_id_foreign` FOREIGN KEY (`beel_baseline_id`) REFERENCES `beel_baselines`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `beel_baselines_fish_species_details_fish_species_id_foreign` FOREIGN KEY (`fish_species_id`) REFERENCES `fish_species`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
            DB::statement("ALTER TABLE `beel_baselines_fish_production_details` ADD CONSTRAINT `beel_baselines_fish_production_details_beel_baseline_id_foreign` FOREIGN KEY (`beel_baseline_id`) REFERENCES `beel_baselines`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `beel_baselines_fish_production_details_fish_species_id_foreign` FOREIGN KEY (`fish_species_id`) REFERENCES `fish_species`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
            DB::statement("ALTER TABLE `beel_baselines_fish_aquatic_details` ADD CONSTRAINT `beel_baselines_fish_aquatic_details_beel_baseline_id_foreign` FOREIGN KEY (`beel_baseline_id`) REFERENCES `beel_baselines`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT, ADD CONSTRAINT `beel_baselines_fish_aquatic_details_aquatic_species_id_foreign` FOREIGN KEY (`aquatic_species_id`) REFERENCES `aquatic_species`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");

            Schema::dropIfExists('alter_beel_related_migration_tabel');



    }
}
