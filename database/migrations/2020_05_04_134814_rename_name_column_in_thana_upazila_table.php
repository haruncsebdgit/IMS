<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameNameColumnInThanaUpazilaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Known Bug: DBAL Can't rename any column of a table containing enum() column.
        // @link https://stackoverflow.com/a/33142304/1743124
        DB::statement('ALTER TABLE thana_upazilas CHANGE name name_en VARCHAR(255) NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Known Bug: DBAL Can't rename any column of a table containing enum() column.
        // @link https://stackoverflow.com/a/33142304/1743124
        DB::statement('ALTER TABLE thana_upazilas CHANGE name_en name VARCHAR(255) NOT NULL');
    }
}
