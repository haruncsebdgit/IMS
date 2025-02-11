<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnAndAddForeignKeyInProcurementPlannedDateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            $table->dropColumn('procurement_planned_date_id');
            $table->unsignedBigInteger('planned_date_id')->after('organization_id');
        });

        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('planned_date_id')->references('id')->on('procurement_planned_dates')->onUpdate('cascade')->onDelete('restrict');
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
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP FOREIGN KEY procurement_planned_date_archives_organization_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP FOREIGN KEY procurement_planned_date_archives_planned_date_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP FOREIGN KEY procurement_planned_date_archives_procure_pack_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP FOREIGN KEY procurement_planned_date_archives_procure_pack_lot_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP FOREIGN KEY procurement_planned_date_archives_procure_year_id_foreign;');

        // Drop Indexes
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP INDEX procurement_planned_date_archives_organization_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP INDEX procurement_planned_date_archives_planned_date_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP INDEX procurement_planned_date_archives_procure_pack_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP INDEX procurement_planned_date_archives_procure_pack_lot_id_foreign;');
        DB::statement('ALTER TABLE procurement_planned_date_archives DROP INDEX procurement_planned_date_archives_procure_year_id_foreign;');

        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            $table->dropColumn('planned_date_id');
            $table->unsignedBigInteger('procurement_planned_date_id')->after('organization_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
