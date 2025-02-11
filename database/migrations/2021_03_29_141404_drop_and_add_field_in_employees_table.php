<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAndAddFieldInEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('employees', function (Blueprint $table) {
            // Add Column (Organization)
            $table->bigInteger('organization_id')->unsigned()->nullable()->after('employee_image')->comment('Organization ID');

            // Add Foreign (Organization)
            $table->foreign('organization_id')->references('id')->on('organizations');

            // Drop Foreign (Organogram)
            $table->dropForeign(['organogram_id']);

            // Drop the Column (Organogram)
            $table->dropColumn('organogram_id');
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

        Schema::table('employees', function (Blueprint $table) {
            // Add Column (Organogram)
            $table->bigInteger('organogram_id')->unsigned()->after('designation_id')->comment('Organogram/Office ID');

            // Add Foreign (Organogram)
            $table->foreign('organogram_id')->references('id')->on('organograms');

            // Drop Foreign (Organization)
            $table->dropForeign(['organization_id']);

            // Drop the Column (Organization)
            $table->dropColumn('organization_id');
        });

        Schema::enableForeignKeyConstraints();
    }
}
