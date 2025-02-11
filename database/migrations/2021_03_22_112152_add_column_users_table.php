<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable()->after('id')->comment('Organization Id');
            $table->unsignedBigInteger('employee_id')->nullable()->after('organization_id')->comment('employee Id');
            $table->enum('user_type', ['internal', 'external'])->nullable()->after('employee_id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['organization_id']);

            $table->dropColumn(['employee_id']);
            $table->dropColumn(['organization_id']);
            $table->dropColumn(['user_type']);
            
            Schema::enableForeignKeyConstraints();
        });
    }
}
