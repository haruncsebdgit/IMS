<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToCigMicroplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cig_microplans', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id')->nullable()->after('organization_id')->comment('Only For DLS');
            $table->unsignedBigInteger('union_id')->nullable()->after('organization_id')->comment('Only For DLS');
            $table->unsignedBigInteger('division_id')->nullable()->after('organization_id')->comment('Only For DLS');
            
            
            $table->unsignedBigInteger('cig_id')->nullable()->change();
            $table->date('entry_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cig_microplans', function (Blueprint $table) {
            $table->dropColumn(['division_id']);
            $table->dropColumn(['district_id']);
            $table->dropColumn(['union_id']);
            
        });
    }
}
