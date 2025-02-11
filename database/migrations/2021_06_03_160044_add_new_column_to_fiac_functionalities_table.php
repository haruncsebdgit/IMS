<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToFiacFunctionalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiac_functionalities', function (Blueprint $table) {

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

            $table->foreignId('organization_id')
            ->nullable()->after('project_id')
            ->constrained('organizations')
            ->onUpdate('cascade')
            ->onDelete('restrict');

            $table->unsignedBigInteger('fiac_id')->nullable()->change();
            $table->dropColumn(['ceal_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiac_functionalities', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('fiac_functionalities_organogram_id_foreign');
            $table->dropForeign('fiac_functionalities_project_id_foreign');
            $table->dropForeign('fiac_functionalities_organization_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id', 'organization_id']);
            Schema::enableForeignKeyConstraints();

            $table->text('ceal_id')->nullable()->after('financial_years_id');
            $table->text('fiac_id')->nullable()->change();

        });
    }
}
