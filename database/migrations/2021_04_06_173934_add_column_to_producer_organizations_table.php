<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProducerOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('producer_organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id')->comment('Organization Id');
            $table->unsignedBigInteger('lbf_employee_id')->nullable()->after('organization_id')->comment('LBF employee');
            $table->string('ccmc_location_latitude', 100)->nullable()->after('lbf_employee_id')->comment('CCMC Location Coordinates');
            $table->string('ccmc_location_longitude', 100)->nullable()->after('ccmc_location_latitude')->comment('CCMC Location Coordinates');
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
        Schema::table('producer_organizations', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['organization_id']);

            $table->dropColumn(['ccmc_location_longitude']);
            $table->dropColumn(['ccmc_location_latitude']);
            $table->dropColumn(['lbf_employee_id']);
            $table->dropColumn(['organization_id']);
          
          
            
            Schema::enableForeignKeyConstraints();
        });
    }
}
