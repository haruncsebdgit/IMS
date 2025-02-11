<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsDeletableCommonlabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('common_labels', function (Blueprint $table) {
            $table->boolean('is_delatable')->default(1)->after('name_bn')->nullable();
            
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
            $table->dropColumn('is_delatable');
        });
    }
}
