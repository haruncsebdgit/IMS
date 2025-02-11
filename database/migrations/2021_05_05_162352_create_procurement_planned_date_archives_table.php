<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcurementPlannedDateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_planned_date_archives', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');

            
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('procurement_planned_date_id');
            $table->unsignedBigInteger('procure_pack_id');
            $table->unsignedBigInteger('procure_pack_lot_id')->nullable();
            $table->unsignedBigInteger('procure_year_id')->nullable();
            
            
            $table->date('initial_date');
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
            
            
            

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');


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
        Schema::dropIfExists('procurement_planned_date_archives');
    }
}
