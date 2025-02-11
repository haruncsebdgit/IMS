<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUnionIdToOrganogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE `organograms` ADD COLUMN `union_id` BIGINT(20) UNSIGNED NULL AFTER `upazila_id`, ADD CONSTRAINT `FK_organograms_union_wards` FOREIGN KEY (`union_id`) REFERENCES `union_wards`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT;');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE `organograms` DROP COLUMN `union_id`, DROP INDEX `FK_organograms_union_wards`, DROP FOREIGN KEY `FK_organograms_union_wards`; ');

        Schema::enableForeignKeyConstraints();
    }
}
