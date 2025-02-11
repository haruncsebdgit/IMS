<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCigTypeToCigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cigs', function (Blueprint $table) {
            $table->enum('cig_type', ['20', '30'])->after('id')->comment('CIG Type: 20/30 members CIG');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cigs', function (Blueprint $table) {
            $table->dropColumn(['cig_type']);
        });
    }
}
