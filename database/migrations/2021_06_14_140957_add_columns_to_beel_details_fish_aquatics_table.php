<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBeelDetailsFishAquaticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beel_details_fish_aquatics', function (Blueprint $table) {
            $table->string('percentage', 100)->nullable()->after('aquatic_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beel_details_fish_aquatics', function (Blueprint $table) {
            $table->dropColumn(['percentage']);
        });
    }
}
