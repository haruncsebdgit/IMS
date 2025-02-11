<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPoSalesCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_sales_collections', function (Blueprint $table) {
            $table->string('member_type', 50)
                    ->nullable()->after('id');
            $table->foreignId('farmer_id')
                    ->nullable()->after('member_type')
                    ->constrained('farmers')
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
            $table->dropForeign('po_sales_collections_farmer_id_foreign');
            $table->dropColumn(['farmer_id', 'member_type']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
