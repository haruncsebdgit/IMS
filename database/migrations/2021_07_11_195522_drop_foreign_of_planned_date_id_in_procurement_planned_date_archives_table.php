<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignOfPlannedDateIdInProcurementPlannedDateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       // Schema::disableForeignKeyConstraints();
        // Drop Columns
       // DB::statement('ALTER TABLE procurement_planned_date_archives DROP FOREIGN KEY procurement_planned_date_archives_planned_date_id_foreign;');

        // Drop Indexes
       // DB::statement('ALTER TABLE procurement_planned_date_archives DROP INDEX procurement_planned_date_archives_planned_date_id_foreign;');
      //  Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      //  Schema::disableForeignKeyConstraints();
      //  Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
     //       $table->foreign('planned_date_id')->references('id')->on('procurement_planned_dates')->onUpdate('cascade')->onDelete('restrict');
     //   });
     //   Schema::enableForeignKeyConstraints();
    }
}
