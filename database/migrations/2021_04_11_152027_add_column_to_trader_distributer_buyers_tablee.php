<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTraderDistributerBuyersTablee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trader_distributer_buyers', function (Blueprint $table) {
            $table->unsignedBigInteger('trader_type')->nullable()->change();
            $table->unsignedBigInteger('export_country')->nullable()->change();
            $table->dropColumn('item_info');
            $table->dropColumn('agent_of_export_company');
            $table->foreign('trader_type')->references('id')->on('common_labels')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('export_country')->references('id')->on('common_labels')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trader_distributer_buyers', function (Blueprint $table) {
            Schema::enableForeignKeyConstraints();

            $table->dropForeign(['export_country']);
            $table->dropForeign(['trader_type']);

            $table->string('agent_of_export_company');
            $table->string('item_info');
            // $table->string('export_country')->nullable();
            // $table->string('trader_type')->nullable();
         
            Schema::disableForeignKeyConstraints();
        });
    }
}
