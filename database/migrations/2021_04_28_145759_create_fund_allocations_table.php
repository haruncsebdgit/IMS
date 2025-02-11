<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFundAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aif_fund_allocations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->string('aif_code', 50)->comment('AIF Code (AIF-2, AIF-3) from Fund Type setup. ');
            $table->unsignedBigInteger('organization_id')->comment('Organization Id');
            $table->unsignedBigInteger('division_id')->comment('Regions id from regions table fro DAE and division id for others');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id');
            $table->date('award_date');
            $table->string('beneficiary_type')->comment('CIG/PO/SAAO/Enterpreneur');
            $table->unsignedBigInteger('beneficiary_name_cig_id')->nullable()->comment('CIG ID');
            $table->unsignedBigInteger('beneficiary_name_po_id')->nullable()->comment('PO ID');
            $table->unsignedBigInteger('beneficiary_name_sao_ceal_id')->nullable()->comment('SAOO/LEAF/CEAL ID');
            $table->unsignedBigInteger('cig_member_id')->nullable()->comment('CIG Member ID');
            $table->unsignedBigInteger('po_member_id')->nullable()->comment('PO Member ID');
            $table->string('beneficiary_name_enterpreneur')->nullable();
            $table->text('enterpreneur_address')->nullable();
            $table->string('enterpreneur_trade_license')->nullable();
            $table->string('enterpreneur_nid')->nullable();
            $table->string('enterpreneur_mobile')->nullable();
            $table->string('enterpreneur_gender')->nullable();
            $table->unsignedBigInteger('sub_project_type_id');
            $table->string('sub_project_title')->nullable();
            $table->decimal('total_project_value',  $precision = 12, $scale = 2)->nullable();
            $table->decimal('matching_grant_amount',  $precision = 12, $scale = 2)->nullable();
            $table->decimal('cig_po_ent_share_amount',  $precision = 12, $scale = 2)->nullable();
            $table->date('allocation_date')->nullable();
            $table->date('check_issue_date')->nullable();
            $table->text('remarks')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->timestamps();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('beneficiary_name_cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('beneficiary_name_po_id')->references('id')->on('producer_organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('beneficiary_name_sao_ceal_id')->references('id')->on('saaos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('po_member_id')->references('id')->on('po_mmc_members')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('aif_fund_allocations');
    }
}
