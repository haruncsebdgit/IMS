<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnLogoutDatetimeToAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE `access_logs` CHANGE `logout_datetime` `logout_datetime` DATETIME NULL;');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE `access_logs` CHANGE `logout_datetime` `logout_datetime` DATETIME NULL;');

        Schema::enableForeignKeyConstraints();
    }
}
