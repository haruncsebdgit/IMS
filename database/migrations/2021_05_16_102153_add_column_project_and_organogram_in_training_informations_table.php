<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProjectAndOrganogramInTrainingInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training_informations', function (Blueprint $table) {
            $table->unsignedBigInteger('upazila_id')->nullable()->after('organization_id')->comment('For All');
            $table->unsignedBigInteger('district_id')->nullable()->after('organization_id')->comment('For All');
            $table->unsignedBigInteger('division_id')->nullable()->after('organization_id')->comment('For All');
            $table->unsignedBigInteger('project_id')->nullable()->after('organization_id')->comment('Project');
            $table->unsignedBigInteger('organogram_id')->nullable()->after('organization_id')->comment('organogram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_informations', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn(['organogram_id']);
            $table->dropColumn(['project_id']);
            $table->dropColumn(['division_id']);
            $table->dropColumn(['district_id']);
            $table->dropColumn(['upazila_id']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
