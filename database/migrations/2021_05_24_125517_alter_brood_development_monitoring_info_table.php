<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBroodDevelopmentMonitoringInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brood_development_monitoring_infos', function (Blueprint $table) {
            $table->foreign('fish_species_monitoring_id', 'fs_spe_mon_id')
                ->references('id')
                ->on('fish_species')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE `brood_development_monitoring_infos` DROP FOREIGN KEY `fs_spe_mon_id`;');

        Schema::enableForeignKeyConstraints();
    }
}
