<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAifFundAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aif_fund_allocations', function (Blueprint $table) {
            $table->text('source_of_fund')->nullable()->after('cig_po_ent_share_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aif_fund_allocations', function (Blueprint $table) {
            $table->dropColumn(['source_of_fund']);
        });
    }
}
