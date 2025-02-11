<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCigMemberIdToDemoProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demo_productions', function (Blueprint $table) {
            $table->unsignedBigInteger('cig_member_id')->nullable()->after('cig_id')->comment('CIG Member Id');
            $table->dropColumn(['farmer_name']);
            $table->unsignedBigInteger('farmer_id')->nullable()->after('cig_member_id')->comment('CIG Member Id');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('farmer_id')->references('id')->on('farmers')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demo_productions', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['farmer_id']);
            $table->dropForeign(['cig_member_id']);

            $table->dropColumn(['farmer_id']);
            $table->string('farmer_name');
            $table->dropColumn(['cig_member_id']);
            
            Schema::enableForeignKeyConstraints();
        });
    }
}
