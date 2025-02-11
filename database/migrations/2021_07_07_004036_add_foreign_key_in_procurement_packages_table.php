<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyInProcurementPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('procurement_packages', function (Blueprint $table) {
            $table->foreign('procure_type_id')->references('id')->on('procurement_types')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('procure_year')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('method_type_id')->references('id')->on('procurement_methods')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('authority')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
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
        DB::statement('ALTER TABLE procurement_packages DROP FOREIGN KEY procurement_packages_procure_type_id_foreign;');
        DB::statement('ALTER TABLE procurement_packages DROP FOREIGN KEY procurement_packages_procure_year_foreign;');
        DB::statement('ALTER TABLE procurement_packages DROP FOREIGN KEY procurement_packages_method_type_id_foreign;');
        DB::statement('ALTER TABLE procurement_packages DROP FOREIGN KEY procurement_packages_authority_foreign;');

        // Drop Indexes
        DB::statement('ALTER TABLE procurement_packages DROP INDEX procurement_packages_procure_type_id_foreign;');
        DB::statement('ALTER TABLE procurement_packages DROP INDEX procurement_packages_procure_year_foreign;');
        DB::statement('ALTER TABLE procurement_packages DROP INDEX procurement_packages_method_type_id_foreign;');
        DB::statement('ALTER TABLE procurement_packages DROP INDEX procurement_packages_authority_foreign;');
        Schema::enableForeignKeyConstraints();
    }
}
