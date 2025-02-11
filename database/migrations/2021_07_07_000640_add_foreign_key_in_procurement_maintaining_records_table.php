<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInProcurementMaintainingRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('procurement_maintaining_records', function (Blueprint $table) {
            $table->foreign('organogram_id')->references('id')->on('organograms')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('procure_type_id')->references('id')->on('procurement_types')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('procure_year')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('procure_pack_id')->references('id')->on('procurement_packages')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('procuring_entity_id')->references('id')->on('procurement_entities')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('budget_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
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
        DB::statement('ALTER TABLE procurement_maintaining_records DROP FOREIGN KEY procurement_maintaining_records_organogram_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP FOREIGN KEY procurement_maintaining_records_project_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP FOREIGN KEY procurement_maintaining_records_procure_type_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP FOREIGN KEY procurement_maintaining_records_procure_year_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP FOREIGN KEY procurement_maintaining_records_procure_pack_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP FOREIGN KEY procurement_maintaining_records_procuring_entity_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP FOREIGN KEY procurement_maintaining_records_budget_type_id_foreign;');

        // Drop Indexes
        DB::statement('ALTER TABLE procurement_maintaining_records DROP INDEX procurement_maintaining_records_organogram_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP INDEX procurement_maintaining_records_project_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP INDEX procurement_maintaining_records_procure_type_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP INDEX procurement_maintaining_records_procure_year_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP INDEX procurement_maintaining_records_procure_pack_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP INDEX procurement_maintaining_records_procuring_entity_id_foreign;');
        DB::statement('ALTER TABLE procurement_maintaining_records DROP INDEX procurement_maintaining_records_budget_type_id_foreign;');
        Schema::enableForeignKeyConstraints();
    }
}
