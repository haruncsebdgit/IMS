<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPoMmcMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('po_mmc_members', function (Blueprint $table) {
            $table->string('name_of_member')->nullable()->after('id')->comment('For DLS & DoF. DoF: name of manager/LMF. DLS: Name of Member');
            $table->enum('member_type', ['cig', 'non-cig'])->nullable()->after('name_of_member')->comment('For DLS.');
            $table->unsignedBigInteger('cig_id')->nullable()->after('member_type')->comment('For DLS.');
            $table->unsignedBigInteger('farmer_id')->nullable()->after('cig_id')->comment('For DLS.');
            $table->tinyInteger('is_ethnic')->nullable()->after('farmer_id')->comment('For DLS.');
            $table->unsignedBigInteger('type_of_ethnicity')->nullable()->after('is_ethnic')->comment('For DLS.');
            $table->unsignedBigInteger('occupation_id')->nullable()->after('type_of_ethnicity')->comment('For DLS.');
            $table->string('spouse_name')->nullable()->after('occupation_id')->comment('For DLS.');
            $table->string('village')->nullable()->after('spouse_name')->comment('For DLS.');
            $table->unsignedBigInteger('membership_category_id')->nullable()->after('village')->comment('For DLS.');
            $table->unsignedBigInteger('cig_member_id')->nullable()->change();
            $table->unsignedBigInteger('designation_id')->nullable()->change();
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('farmer_id')->references('id')->on('farmers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('membership_category_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('occupation_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('po_mmc_members', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            
            $table->dropForeign(['occupation_id']);
            $table->dropForeign(['membership_category_id']);
            $table->dropForeign(['farmer_id']);
            $table->dropForeign(['cig_id']);

            $table->unsignedBigInteger('designation_id')->change();
            $table->unsignedBigInteger('cig_member_id')->change();
            $table->dropColumn(['membership_category_id']);
            $table->dropColumn(['village']);
            $table->dropColumn(['spouse_name']);
            $table->dropColumn(['occupation_id']);
            $table->dropColumn(['type_of_ethnicity']);
            $table->dropColumn(['is_ethnic']);
            $table->dropColumn(['farmer_id']);
            $table->dropColumn(['cig_id']);
            $table->dropColumn(['member_type']);
            $table->dropColumn(['name_of_member']);
        
           
            Schema::enableForeignKeyConstraints();
        });
    }
}
