<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSalesInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_infos', function (Blueprint $table) {

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

        Schema::table('sales_infos', function (Blueprint $table) {
            $table->dropForeign(['fish_species_id']);       
        });
        Schema::enableForeignKeyConstraints();

    }
}