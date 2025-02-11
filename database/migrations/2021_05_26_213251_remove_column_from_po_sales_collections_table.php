<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromPoSalesCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_sales_collections', function (Blueprint $table) {
            $table->dropColumn(['seller_name_other']);
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
            $table->string('seller_name_other', 300)
                    ->nullable()->after('id');
        });
    }
}
