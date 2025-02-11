<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitIdColumnToPoSalesCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_sales_collections', function (Blueprint $table) {
            $table->foreignId('unit_id')
                    ->nullable()->after('item_id')
                    ->constrained('common_labels')
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
        Schema::table('po_sales_collections', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('po_sales_collections_unit_id_foreign');
            $table->dropColumn(['unit_id']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
