<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSeedMultiplicationFarmInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seed_multiplication_farm_information', function (Blueprint $table) {  
            $table->unsignedBigInteger('fish_species_id');

            $table->foreign('fish_species_id')
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
         
        DB::statement('ALTER TABLE `seed_multiplication_farm_information` DROP COLUMN `fish_species_id` , DROP INDEX `seed_multiplication_farm_information_fish_species_id_foreign`, DROP FOREIGN KEY `seed_multiplication_farm_information_fish_species_id_foreign`;');
        // DB::statement('ALTER TABLE `seed_multiplication_farm_information` DROP FOREIGN KEY `fish_species_id`;');
        

        Schema::enableForeignKeyConstraints();
    }
}
