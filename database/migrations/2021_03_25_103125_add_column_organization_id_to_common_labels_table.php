<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrganizationIdToCommonLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('common_labels', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('name_bn')->comment('Organization Id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('common_labels', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['organization_id']);
            $table->dropColumn(['organization_id']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
