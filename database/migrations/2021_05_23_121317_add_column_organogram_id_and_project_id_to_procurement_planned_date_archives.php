<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrganogramIdAndProjectIdToProcurementPlannedDateArchives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            $table->foreignId('organogram_id')
                ->nullable()->after('id')
                ->constrained('organograms')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('project_id')
                ->nullable()->after('organogram_id')
                ->constrained('projects')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procurement_planned_date_archives', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('procurement_planned_date_archives_organogram_id_foreign');
            $table->dropForeign('procurement_planned_date_archives_project_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
