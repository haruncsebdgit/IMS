<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUrlToThanaUpazilasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thana_upazilas', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();

            DB::statement('ALTER TABLE `thana_upazilas` ADD `url` VARCHAR(150) NULL AFTER `name_bn`;');
    
            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE thana_upazilas DROP COLUMN url;');

        Schema::enableForeignKeyConstraints();
    }
}
