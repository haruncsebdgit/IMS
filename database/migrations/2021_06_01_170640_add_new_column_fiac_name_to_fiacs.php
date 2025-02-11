<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnFiacNameToFiacs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiacs', function (Blueprint $table) {
            $table->string('fiac_name')->nullable()->after('fiac_address');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiacs', function (Blueprint $table) {
            $table->dropColumn('fiac_name');
        });
    }
}
