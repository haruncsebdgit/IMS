<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'name_en');

            $table->string('name_bn')->nullable()->after('name'); // after 'name' instead of 'name_en' is tested good.
            $table->string('username',100)->unique('unique_username')->nullable()->after('name_bn')->comment('Serve as a login ID');
            $table->string('phone', 20)->nullable()->after('remember_token');
            $table->string('blood_group', 20)->nullable()->after('phone');
            $table->bigInteger('designation_id')->unsigned()->nullable()->after('blood_group')->comment('From Common Labels: Designation');
            $table->bigInteger('district_id')->unsigned()->nullable()->after('designation_id')->comment('From Districts');
            $table->bigInteger('upazila_id')->unsigned()->nullable()->after('district_id')->comment('From Thana/Upazila');
            $table->bigInteger('union_id')->unsigned()->nullable()->after('upazila_id')->comment('From Union/Ward');
            $table->string('user_level')->after('union_id');
            $table->boolean('is_active')->default(true)->after('user_level');

            // Relationship.
            $table->foreign('designation_id')->references('id')->on('common_labels');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas');
            $table->foreign('union_id')->references('id')->on('union_wards');
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

            $table->dropForeign(['designation_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['upazila_id']);
            $table->dropForeign(['union_id']);

            $table->renameColumn('name_en', 'name');

            $table->dropColumn(['name_bn', 'username', 'phone', 'blood_group', 'designation_id', 'district_id', 'upazila_id', 'union_id', 'user_level', 'is_active']);

            Schema::enableForeignKeyConstraints();
        });
    }
}
