<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPoSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_sales', function (Blueprint $table) {
            $table->enum('member_type', ['cig', 'non-cig'])->nullable()->after('id')->comment('For DoF.');
            $table->unsignedBigInteger('cig_id')->nullable()->after('member_type')->comment('Only for DoF');
            $table->unsignedBigInteger('cig_member_id')->nullable()->after('cig_id')->comment('Only for DoF');
            $table->unsignedBigInteger('farmer_id')->nullable()->after('cig_member_id')->comment('For DoF.');
            $table->unsignedBigInteger('buyer_trader_id')->nullable()->after('farmer_id')->comment('For DoF.');
            $table->unsignedBigInteger('communication_channel_id')->nullable()->after('buyer_trader_id')->comment('For DoF & DLS.');
            $table->string('fish_transport_media', 300)->nullable()->after('communication_channel_id')->comment('For DoF.');
            $table->unsignedBigInteger('transport_mode_id')->nullable()->after('fish_transport_media')->comment('For DoF & DLS.');
            $table->unsignedBigInteger('marketplace_type_id')->nullable()->after('transport_mode_id')->comment('For DoF.');
            $table->unsignedBigInteger('packaging_process_id')->nullable()->after('marketplace_type_id')->comment('For DoF.');
            $table->unsignedBigInteger('buyer_trader_type_id')->nullable()->after('packaging_process_id')->comment('For DLS.');
            $table->date('date_of_add_posting')->nullable()->after('buyer_trader_type_id')->comment('For DoF.');
            $table->integer('sku_number')->nullable()->after('date_of_add_posting')->comment('For DoF.');
            $table->unsignedBigInteger('delivery_mode_id')->nullable()->after('sku_number')->comment('For DoF.');
            
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('farmer_id')->references('id')->on('farmers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('buyer_trader_id')->references('id')->on('trader_distributer_buyers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('communication_channel_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('transport_mode_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('marketplace_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('packaging_process_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('buyer_trader_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');

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

            $table->dropForeign(['buyer_trader_type_id']);
            $table->dropForeign(['packaging_process_id']);
            $table->dropForeign(['marketplace_type_id']);
            $table->dropForeign(['transport_mode_id']);
            $table->dropForeign(['communication_channel_id']);
            $table->dropForeign(['buyer_trader_id']);
            $table->dropForeign(['farmer_id']);
            $table->dropForeign(['cig_member_id']);
            $table->dropForeign(['cig_id']);

            
            $table->dropColumn(['delivery_mode_id']);
            $table->dropColumn(['sku_number']);
            $table->dropColumn(['date_of_add_posting']);
            $table->dropColumn(['buyer_trader_type_id']);
            $table->dropColumn(['packaging_process_id']);
            $table->dropColumn(['marketplace_type_id']);
            $table->dropColumn(['transport_mode_id']);
            $table->dropColumn(['fish_transport_media']);
            $table->dropColumn(['communication_channel_id']);
            $table->dropColumn(['buyer_trader_id']);
            $table->dropColumn(['farmer_id']);
            $table->dropColumn(['cig_member_id']);
            $table->dropColumn(['cig_id']);
            $table->dropColumn(['member_type']);
            
            Schema::enableForeignKeyConstraints();
        });
    }
}
