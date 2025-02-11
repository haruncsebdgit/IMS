<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintainingRecordOfProcurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintaining_record_of_procurements', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');

            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('organogram_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('procure_type_id')->nullable();
            $table->unsignedBigInteger('procure_year')->nullable();
            $table->unsignedBigInteger('procure_pack_id')->nullable();
            $table->unsignedBigInteger('procuring_entity_id')->nullable();
            $table->unsignedBigInteger('budget_type_id')->nullable();
            
            
            
            $table->date('advertisement_date')->nullable();
            $table->date('date_of_noa_po')->nullable();
            $table->decimal('contract_amount')->nullable();
            $table->string('tenderer_consultant')->nullable();
            $table->date('contract_signing')->nullable();
            $table->date('submission_date_of_performance_security')->nullable();
            $table->date('contract_amendment')->nullable();
            $table->decimal('total_amount_paid')->nullable();
            $table->decimal('performance_security_amount')->nullable();
            $table->date('delivery_last_date')->nullable();
            $table->string('delivery_location')->nullable();
            $table->date('performance_security_return_date')->nullable();
            $table->string('current_status')->nullable();
            $table->decimal('proposal_received')->nullable();
            

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
        Schema::dropIfExists('maintaining_record_of_procurements');
    }
}
