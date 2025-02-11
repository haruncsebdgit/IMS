<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCodeToOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        DB::statement("ALTER TABLE organizations ADD COLUMN code ENUM('BARC','DAE','DOF','DLS','PMU') DEFAULT NULL AFTER short_name;");
        DB::statement("ALTER TABLE organizations ADD COLUMN banner VARCHAR(500) DEFAULT NULL AFTER logo;");
        DB::statement("ALTER TABLE organizations ADD COLUMN sort_order BIGINT(20) UNSIGNED DEFAULT NULL AFTER is_active;");
   
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

        DB::statement('ALTER TABLE organizations DROP COLUMN sort_order;');
        DB::statement('ALTER TABLE organizations DROP COLUMN banner;');
        DB::statement('ALTER TABLE organizations DROP COLUMN code;');

        Schema::enableForeignKeyConstraints();
    }
}
