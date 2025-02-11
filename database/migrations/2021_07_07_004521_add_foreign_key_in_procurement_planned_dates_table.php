<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInProcurementPlannedDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('procurement_planned_dates', function (Blueprint $table) {
            $table->foreign('procure_pack_id')->references('id')->on('procurement_packages')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('procure_pack_lot_id')->references('id')->on('procurement_packages')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('procure_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
        });
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
        // Drop Columns
        DB::statement('ALTER TABLE procurement_planned_dates DROP FOREIGN KEY procurement_planned_dates_procure_pack_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_dates DROP FOREIGN KEY procurement_planned_dates_procure_pack_lot_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_dates DROP FOREIGN KEY procurement_planned_dates_procure_year_id_foreign;');

        // Drop Indexes
        DB::statement('ALTER TABLE procurement_planned_dates DROP INDEX procurement_planned_dates_procure_pack_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_dates DROP INDEX procurement_planned_dates_procure_pack_lot_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_dates DROP INDEX procurement_planned_dates_procure_year_id_foreign;');
        Schema::enableForeignKeyConstraints();
    }
}
