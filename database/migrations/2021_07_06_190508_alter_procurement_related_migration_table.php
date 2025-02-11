<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProcurementRelatedMigrationTable extends Migration
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
            $table->dropColumn('procure_pack_id');
            $table->dropColumn('procure_pack_lot_id');
        });

        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            $table->dropColumn('procure_pack_id');
            $table->dropColumn('procure_pack_lot_id');
        });

        Schema::table('maintaining_record_of_procurements', function (Blueprint $table) {
            $table->dropColumn('procure_pack_id');
            $table->dropColumn('procuring_entity_id');
        });

        Schema::table('inv_suppliers', function (Blueprint $table) {
            $table->dropForeign(['tender_id']);

            $table->dropColumn('tender_id');
        });

        Schema::rename('maintaining_record_of_procurements', 'procurement_maintaining_records');
        Schema::rename('packages', 'procurement_packages');
        Schema::rename('procuring_entities', 'procurement_entities');
        Schema::rename('committees', 'procurement_committees');
        Schema::rename('tenderers', 'procurement_tenderers');

        Schema::table('procurement_planned_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('procure_pack_id')->nullable()->after('organization_id');
            $table->unsignedBigInteger('procure_pack_lot_id')->nullable()->after('procure_pack_id');
        });

        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            $table->unsignedBigInteger('procure_pack_id')->after('procurement_planned_date_id');
            $table->unsignedBigInteger('procure_pack_lot_id')->nullable()->after('procure_pack_id');
        });

        Schema::table('procurement_maintaining_records', function (Blueprint $table) {
            $table->unsignedBigInteger('procure_pack_id')->nullable()->after('procure_year');
            $table->unsignedBigInteger('procuring_entity_id')->nullable()->after('procure_pack_id');
        });

        Schema::table('inv_suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('tender_id')->nullable();

            $table->foreign('tender_id')->references('id')->on('procurement_tenderers')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::table('inv_suppliers', function (Blueprint $table) {
            $table->dropForeign(['tender_id']);

            $table->dropColumn('tender_id');
        });

        Schema::table('procurement_maintaining_records', function (Blueprint $table) {
            $table->dropColumn('procure_pack_id');
            $table->dropColumn('procuring_entity_id');
        });

        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            $table->dropColumn('procure_pack_id');
            $table->dropColumn('procure_pack_lot_id');
        });

        Schema::table('procurement_planned_dates', function (Blueprint $table) {
            $table->dropColumn('procure_pack_id');
            $table->dropColumn('procure_pack_lot_id');
        });

        Schema::rename('procurement_maintaining_records', 'maintaining_record_of_procurements');
        Schema::rename('procurement_packages', 'packages');
        Schema::rename('procurement_entities', 'procuring_entities');
        Schema::rename('procurement_tenderers', 'tenderers');
        Schema::rename('procurement_committees', 'committees');

        Schema::table('inv_suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('tender_id')->nullable()->after('address');

            $table->foreign('tender_id')->references('id')->on('tenderers')->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::table('maintaining_record_of_procurements', function (Blueprint $table) {
            $table->unsignedBigInteger('procure_pack_id')->nullable()->after('procure_year');
            $table->unsignedBigInteger('procuring_entity_id')->nullable()->after('procure_pack_id');
        });

        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            $table->unsignedBigInteger('procure_pack_id')->after('procurement_planned_date_id');
            $table->unsignedBigInteger('procure_pack_lot_id')->nullable()->after('procure_pack_id');
        });

        Schema::table('procurement_planned_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('procure_pack_id')->nullable()->after('organization_id');
            $table->unsignedBigInteger('procure_pack_lot_id')->nullable()->after('procure_pack_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
