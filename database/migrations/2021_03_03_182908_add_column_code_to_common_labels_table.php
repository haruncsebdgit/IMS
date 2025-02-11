<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCodeToCommonLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('common_labels', function (Blueprint $table) {
            $table->string('code',10)->nullable()->after('status')->comment('Code');
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
            $table->dropColumn(['code']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
