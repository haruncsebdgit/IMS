<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMainOccupationColumnToCigMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cig_members', function (Blueprint $table) {
            /*$table->foreignId('main_occupation_id')
                ->nullable()->comment('Only for DLS')->after('cig_designation_id')
                ->constrained('common_labels')
                ->onUpdate('cascade')
                ->onDelete('restrict');*/
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
            $table->dropForeign('cig_members_main_occupation_id_foreign');
            $table->dropColumn(['main_occupation_id']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
