<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBroodDevelopmentFingerlingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brood_development_fingerlings_production_infos', function (Blueprint $table) {
            $table->foreign('fish_species_fingerlings_id', 'fs_sp_fn_id')
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

        DB::statement('ALTER TABLE `brood_development_fingerlings_production_infos` DROP FOREIGN KEY `fs_sp_fn_id`;');

        Schema::enableForeignKeyConstraints();
    }
}
