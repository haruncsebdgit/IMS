<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldInFinancialYearsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement("ALTER TABLE financial_years ADD COLUMN is_current_fy TINYINT(4) DEFAULT 0 NOT NULL AFTER is_active;");
   
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

        DB::statement('ALTER TABLE financial_years DROP COLUMN is_current_fy;');
       
        Schema::enableForeignKeyConstraints();
    }
}
