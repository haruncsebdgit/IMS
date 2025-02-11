<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCascadeDeleteWithUsersInAllTable extends Migration
{
    private function getTableName()
    {
        $tableName = array(
            'divisions',
            'districts',
            'thana_upazilas',
            'union_wards',
            'common_labels'
    
        );

        return $tableName;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = $this->getTableName();

        Schema::disableForeignKeyConstraints();
        foreach ($tables as $value) {
            Schema::table($value, function (Blueprint $table) {
                // relationship
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            });
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = $this->getTableName();

        Schema::disableForeignKeyConstraints();
        foreach ($tables as $value) {
            Schema::table($value, function (Blueprint $table) {
                // relationship
                $table->dropForeign(['created_by']);
                $table->dropForeign(['updated_by']);
            });
        }
        Schema::enableForeignKeyConstraints();
    }
}
