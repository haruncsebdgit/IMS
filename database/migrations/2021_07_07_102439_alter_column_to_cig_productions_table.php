<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnToCigProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cig_productions', function (Blueprint $table) {
            $table->unsignedBigInteger('used_technology_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cig_productions', function (Blueprint $table) {
            $table->unsignedBigInteger('used_technology_id')->change();
        });
    }
}
