<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPoMemberIdToPoSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('po_member_id')->nullable()->after('po_ccmc_id')->comment('Only for DLS');
            $table->foreign('po_member_id')->references('id')->on('po_mmc_members')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po_sales', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            DB::statement('ALTER TABLE po_sales DROP FOREIGN KEY po_sales_po_member_id_foreign;');
            DB::statement('ALTER TABLE po_sales DROP column po_member_id;');
            Schema::enableForeignKeyConstraints();
        });
    }
}
