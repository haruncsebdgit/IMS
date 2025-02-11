<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectIdOrganogramIdInAllCigScopeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cigs', function (Blueprint $table) {
            $table->foreignId('organogram_id')
                    ->nullable()->after('id')
                    ->constrained('organograms')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('project_id')
                    ->nullable()->after('organogram_id')
                    ->constrained('projects')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
        });
        Schema::table('cig_productions', function (Blueprint $table) {
            $table->foreignId('organogram_id')
                    ->nullable()->after('id')
                    ->constrained('organograms')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('project_id')
                    ->nullable()->after('organogram_id')
                    ->constrained('projects')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
        });
        Schema::table('cig_account_transactions', function (Blueprint $table) {
            $table->foreignId('organogram_id')
                    ->nullable()->after('id')
                    ->constrained('organograms')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('project_id')
                    ->nullable()->after('organogram_id')
                    ->constrained('projects')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
        });
        Schema::table('cig_members', function (Blueprint $table) {
            $table->foreignId('organogram_id')
                    ->nullable()->after('id')
                    ->constrained('organograms')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('project_id')
                    ->nullable()->after('organogram_id')
                    ->constrained('projects')
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
        Schema::table('cigs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('cigs_organogram_id_foreign');
            $table->dropForeign('cigs_project_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id']);
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('cig_productions', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('cig_productions_organogram_id_foreign');
            $table->dropForeign('cig_productions_project_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id']);
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('cig_account_transactions', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('cig_account_transactions_organogram_id_foreign');
            $table->dropForeign('cig_account_transactions_project_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id']);
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('cig_members', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('cig_members_organogram_id_foreign');
            $table->dropForeign('cig_members_project_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
