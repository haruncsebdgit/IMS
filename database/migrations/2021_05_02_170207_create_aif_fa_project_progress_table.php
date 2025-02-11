<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAifFaProjectProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aif_fa_project_progress', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fund_allocation_id');
            $table->unsignedBigInteger('financial_year_id');
            $table->unsignedBigInteger('tools_technology_id')->comment("Which are issued against fund allocation entry");
            $table->integer('usage_period')->comment("In month");
            $table->integer('beneficiary_number_farmer')->nullable()->comment("For Non CIG Member");
            $table->integer('beneficiary_number_cig_member')->nullable()->comment("For CIG Member");
            $table->integer('family_member_engage')->nullable()->comment("DAE & DLS: No of Familiy member engage in operation");
            $table->integer('hired_person_engage')->nullable()->comment("DAE & DLS: No of Person engage in operation");
            $table->decimal('area_coverage',  $precision = 12, $scale = 2)->nullable()->comment("For DAE & DLS");
            $table->decimal('volume_commodities_carried',  $precision = 12, $scale = 2)->nullable();
            $table->decimal('total_qty_of_goods_transported',  $precision = 12, $scale = 2)->nullable()->comment("For DoF");
            $table->decimal('total_qty_of_livestock_transported',  $precision = 12, $scale = 2)->nullable()->comment("For DLS");
            $table->decimal('total_income',  $precision = 12, $scale = 2);
            $table->decimal('total_expense',  $precision = 12, $scale = 2);
            $table->decimal('total_profit',  $precision = 12, $scale = 2)->nullable();
            $table->tinyInteger('current_status')->nullable()->comment("1=Working/Alive সচল, 0=Out of order/Sold অচল");
            $table->text('remarks')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->timestamps();
            $table->foreign('fund_allocation_id')->references('id')->on('aif_fund_allocations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aif_fa_project_progress');
    }
}
