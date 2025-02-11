<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRegionIdToDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->bigInteger('region_id')->unsigned()->nullable()->after('division_id')->comment('From Regions Table: regions');
            
            // Relationship.
            $table->foreign('region_id')->references('id')->on('regions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('districts', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();

            $table->dropForeign(['region_id']);
            $table->dropColumn(['region_id']);

            Schema::enableForeignKeyConstraints();
        });
    }
}
