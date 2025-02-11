<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAifImpactAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aif_impact_assessments', function (Blueprint $table) {
            $table->unsignedBigInteger('division_id')->nullable()->after('project_id')->comment('Regions id from regions table fro DAE and division id for others');
            $table->unsignedBigInteger('district_id')->nullable()->after('division_id');
            $table->unsignedBigInteger('upazila_id')->nullable()->after('district_id');
            $table->unsignedBigInteger('union_id')->nullable()->after('upazila_id');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aif_impact_assessments', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
    
            DB::statement('ALTER TABLE aif_impact_assessments DROP FOREIGN KEY aif_impact_assessments_union_id_foreign;');
            DB::statement('ALTER TABLE aif_impact_assessments DROP column union_id;');
            DB::statement('ALTER TABLE aif_impact_assessments DROP FOREIGN KEY aif_impact_assessments_upazila_id_foreign;');
            DB::statement('ALTER TABLE aif_impact_assessments DROP column upazila_id;');
            DB::statement('ALTER TABLE aif_impact_assessments DROP FOREIGN KEY aif_impact_assessments_district_id_foreign;');
            DB::statement('ALTER TABLE aif_impact_assessments DROP column district_id;');
            DB::statement('ALTER TABLE aif_impact_assessments DROP column division_id;');
         
            Schema::enableForeignKeyConstraints();
        });
    }
}
