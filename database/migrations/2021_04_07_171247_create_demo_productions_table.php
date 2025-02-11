<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemoProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_productions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('financial_year_id');


            $table->enum('input_type', ['demonstration', 'adapter'])->nullable()->default(null)->comment('DOF');
            $table->enum('type', ['cig', 'non-cig'])->default('cig')->nullable()->default(null)->comment('DOF');
            $table->unsignedBigInteger('cig_id')->nullable()->comment('DOF');
            $table->string('farmer_name', 300)->nullable()->comment('DOF');
            $table->decimal('water_area',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->unsignedBigInteger('demonstrated_technology_id')->nullable()->comment('DOF');
            $table->decimal('duration_in_days',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('number_of_fingerling_stocked',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('total_production_in_kg',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('used_amount_of_feed_in_kg',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('total_cost_in_tk',  $precision = 8, $scale = 2)->nullable()->comment('DOF');
            $table->decimal('total_income_in_tk',  $precision = 8, $scale = 2)->nullable()->comment('DOF');

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->timestamps();

            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('demonstrated_technology_id')->references('id')->on('technologies')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo_productions');
    }
}
