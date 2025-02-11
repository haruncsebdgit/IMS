<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBuyerNameToPoSalesCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_sales_collections', function (Blueprint $table) {
            $table->string('buyer_name', 300)->nullable()->after('ccmc_processing_cost');
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
            $table->dropColumn(['buyer_name']);
        });
    }
}
