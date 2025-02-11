<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptingFarmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adopting_farmers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_region_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('financial_year_id');

            $table->enum('type', ['cig', 'non-cig'])->default('cig')->nullable()->default(null)->comment('DLS,DOF,DAE');
            $table->unsignedBigInteger('cig_id')->nullable()->comment('DLS,DOF,DAE');
            $table->unsignedBigInteger('cig_member_id')->nullable()->comment('DLS,DOF,DAE');
            $table->unsignedBigInteger('farmer_id')->nullable()->comment('DLS,DOF,DAE');
            $table->unsignedBigInteger('category_of_member_id')->nullable()->comment('DLS,DOF,DAE');
            $table->unsignedBigInteger('type_of_resource_id')->nullable()->comment('DOF,DAE');
            $table->unsignedBigInteger('education_level_id')->nullable()->comment('DLS');
         
            $table->decimal('number_of_resource',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('resource_area',  $precision = 8, $scale = 2)->nullable()->comment('DOF');

            $table->string('productivity_before_adoption')->nullable()->comment('DLS');
            $table->string('productivity_before_adoption_unit_id')->nullable()->comment('DLS');

            $table->string('productivity_after_adoption')->nullable()->comment('DLS');
            $table->string('productivity_after_adoption_unit_id')->nullable()->comment('DLS');

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->timestamps();

            $table->foreign('division_region_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('farmer_id')->references('id')->on('farmers')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('adopting_farmers');
    }
}
