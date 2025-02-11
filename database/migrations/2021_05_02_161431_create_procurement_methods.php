<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcurementMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_methods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');

            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('type_id');

            $table->string('name_en')->nullable();
            $table->text('description')->nullable();
            $table->integer('issue_rfp_days')->nullable();
            $table->integer('technical_proposal_opening_days')->nullable();
            $table->integer('technical_prop_evalu_days')->nullable();
            $table->integer('financial_prop_ope_eva_days')->nullable();
            $table->integer('negotiation_days')->nullable();
            $table->integer('approval_days')->nullable();
            $table->integer('tender_opening_days')->nullable();
            $table->integer('tender_evaluation_days')->nullable();
            $table->integer('approval_to_awards_days')->nullable();
            $table->integer('notification_awards_days')->nullable();
            $table->integer('contract_signing_days')->nullable();
            $table->integer('total_contract_sign_days')->nullable();
            $table->integer('contract_completion_days')->nullable();

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->foreign('type_id')->references('id')->on('procurement_types')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procurement_methods');
    }
}
