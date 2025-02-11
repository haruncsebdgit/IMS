<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcurementPlannedDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_planned_dates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');

            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('procure_pack_id')->nullable();
            $table->unsignedBigInteger('procure_pack_lot_id')->nullable();
            $table->unsignedBigInteger('procure_year_id')->nullable();
            
            
            $table->date('initial_date')->nullable();
            $table->unsignedBigInteger('revision_number')->nullable();
            $table->integer('issue_rfp_days')->nullable();
            $table->date('issue_rfp_date')->nullable();
            $table->integer('technical_proposal_opening_days')->nullable();
            $table->date('technical_proposal_opening_date')->nullable();
            $table->integer('technical_prop_evalu_days')->nullable();
            $table->date('technical_prop_evalu_date')->nullable();
            $table->integer('financial_prop_ope_eva_days')->nullable();
            $table->date('financial_prop_ope_eva_date')->nullable();
            $table->integer('negotiation_days')->nullable();
            $table->date('negotiation_date')->nullable();
            $table->integer('approval_days')->nullable();
            $table->date('approval_date')->nullable();
            $table->integer('contract_signing_days')->nullable();
            $table->date('contract_signing_date')->nullable();
            $table->integer('contract_signature_days')->nullable();
            $table->date('contract_signature_date')->nullable();
            $table->integer('contract_completion_days')->nullable();
            $table->date('contract_completion_date')->nullable();
            $table->integer('tender_opening_days')->nullable();
            $table->date('tender_opening_date')->nullable();
            $table->integer('tender_evaluation_days')->nullable();
            $table->date('tender_evaluation_date')->nullable();
            $table->integer('approval_to_award_days')->nullable();
            $table->date('approval_to_award_date')->nullable();
            $table->integer('award_notification_days')->nullable();
            $table->date('award_notification_date')->nullable();
            $table->text('p_remarks')->nullable();
            $table->date('last_initial_date')->nullable();
            $table->integer('last_issue_rfp_days')->nullable();
            $table->date('last_issue_rfp_date')->nullable();
            $table->integer('last_technical_proposal_opening_days')->nullable();
            $table->date('last_technical_proposal_opening_date')->nullable();
            $table->integer('last_technical_prop_evalu_days')->nullable();
            $table->date('last_technical_prop_evalu_date')->nullable();
            $table->integer('last_financial_prop_ope_eva_days')->nullable();
            $table->date('last_financial_prop_ope_eva_date')->nullable();
            $table->integer('last_negotiation_days')->nullable();
            $table->date('last_negotiation_date')->nullable();
            $table->integer('last_approval_days')->nullable();
            $table->date('last_approval_date')->nullable();
            $table->integer('last_contract_signing_days')->nullable();
            $table->date('last_contract_signing_date')->nullable();
            $table->integer('last_contract_signature_days')->nullable();
            $table->date('last_contract_signature_date')->nullable();
            $table->integer('last_contract_completion_days')->nullable();
            $table->date('last_contract_completion_date')->nullable();
            $table->integer('last_tender_opening_days')->nullable();
            $table->date('last_tender_opening_date')->nullable();
            $table->integer('last_tender_evaluation_days')->nullable();
            $table->date('last_tender_evaluation_date')->nullable();
            $table->integer('last_approval_to_award_days')->nullable();
            $table->date('last_approval_to_award_date')->nullable();
            $table->integer('last_award_notification_days')->nullable();
            $table->date('last_award_notification_date')->nullable();
            $table->string('last_p_remarks')->nullable();
            
            

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

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
        Schema::dropIfExists('procurement_planned_dates');
    }
}
