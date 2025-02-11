<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrganogramIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE `users` ADD COLUMN `organogram_id` BIGINT(20) UNSIGNED NULL AFTER `id`;');

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

        DB::statement('ALTER TABLE users DROP COLUMN organogram_id;');

        Schema::enableForeignKeyConstraints();
    }
}
