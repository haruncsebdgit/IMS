<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCigMicroplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cig_microplans', function (Blueprint $table) {
            
            $table->string('name_of_asset')->nullable()->after('description')->comment('For DoF');;
            $table->unsignedBigInteger('number_of_assets')->nullable()->comment('For DoF');;
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
            $table->dropColumn(['name_of_asset']);
            $table->dropColumn(['number_of_assets']);
        });
    }
}
