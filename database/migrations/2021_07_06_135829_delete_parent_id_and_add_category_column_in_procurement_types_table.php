<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteParentIdAndAddCategoryColumnInProcurementTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('procurement_types', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->enum('category', ['goods', 'works', 'services'])->nullable()->after('organization_id');
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
        Schema::table('procurement_types', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->unsignedBigInteger('parent_id')->nullable()->after('organization_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
