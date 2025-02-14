<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToDeWormingCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('de_worming_campaigns', function (Blueprint $table) {
           /* $table->foreignId('organogram_id')
            ->nullable()->after('id')
            ->constrained('organograms')
            ->onUpdate('cascade')
            ->onDelete('restrict');

           $table->foreignId('project_id')
            ->nullable()->after('organogram_id')
            ->constrained('projects')
            ->onUpdate('cascade')
            ->onDelete('restrict');
           */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('de_worming_campaigns', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('de_worming_campaigns_organogram_id_foreign');
            $table->dropForeign('de_worming_campaigns_project_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
