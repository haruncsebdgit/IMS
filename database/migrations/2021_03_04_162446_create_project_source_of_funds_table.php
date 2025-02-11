<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSourceOfFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_source_of_funds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('fund_source_name_id');
            $table->tinyInteger('is_loan_grant')->comment('1 For Laon and 0 for grant');
            $table->string('credit_loan_number', 500);
            $table->integer('fund_contribution')->comment('In percentage');
            $table->decimal('fund_contribution_bdt', $precision = 12, $scale = 2)->nullable();
            $table->decimal('fund_contribution_usd', $precision = 12, $scale = 2)->nullable();

            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('project_source_of_funds');
    }
}
