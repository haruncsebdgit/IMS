<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrganogramIdAndProjectIdToProcuringEntities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procuring_entities', function (Blueprint $table) {

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
        Schema::table('procuring_entities', function (Blueprint $table) {

            Schema::disableForeignKeyConstraints();
            $table->dropForeign('procuring_entities_organogram_id_foreign');
            $table->dropForeign('procuring_entities_project_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id']);
            Schema::enableForeignKeyConstraints();

        });
    }
}
