<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCigMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cig_members', function (Blueprint $table) {
            $table->unsignedBigInteger('eduaction_level_id')->nullable()->after('id')->comment('For DLS');
            $table->unsignedBigInteger('member_category_id')->nullable()->after('eduaction_level_id')->comment('For DLS');
            $table->tinyInteger('is_household_head')->nullable()->after('member_category_id')->comment('For DLS');
            $table->tinyInteger('number_of_resource')->nullable()->after('is_household_head')->comment('For DAE');
            $table->decimal('resource_area', $precision = 8, $scale = 2)->nullable()->after('number_of_resource')->comment('For DAE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cig_members', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn(['eduaction_level_id']);
            $table->dropColumn(['member_category_id']);
            $table->dropColumn(['is_household_head']);
            $table->dropColumn(['number_of_resource']);
            $table->dropColumn(['resource_area']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
