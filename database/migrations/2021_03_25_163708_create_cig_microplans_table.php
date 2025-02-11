<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCigMicroplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cig_microplans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cig_id');
            $table->unsignedBigInteger('financial_year_id');
            $table->date('entry_date');
            $table->text('location')->nullable()->comment('For DoF');
            $table->decimal('cig_yearly_income', $precision = 12, $scale = 2)->nullable()->comment('For DoF');
            $table->decimal('saving_amount_in_cig_bank', $precision = 12, $scale = 2)->nullable()->comment('For DoF');
            $table->decimal('investment_amount', $precision = 12, $scale = 2)->nullable()->comment('For DoF');
            $table->decimal('total_amount', $precision = 12, $scale = 2)->nullable()->comment('For DoF');
            $table->decimal('income_from_investment', $precision = 12, $scale = 2)->nullable()->comment('For DoF');
            $table->text('description')->nullable()->comment('For DoF');
            $table->unsignedBigInteger('type_of_plan_id')->nullable()->comment('For DoF');
            $table->unsignedBigInteger('type_of_problem_id')->nullable()->comment('For DoF');
            $table->unsignedBigInteger('upazila_id')->nullable()->comment('For DLS');
            $table->text('identified_problem')->nullable()->comment('For DLS');
            $table->string('title_of_exhibition')->nullable()->comment('For DLS');
            $table->string('title_of_training')->nullable()->comment('For DLS');
            $table->text('others_expansion_working_title')->nullable()->comment('For DLS');
            $table->integer('exhibition')->nullable()->comment('For DLS');
            $table->integer('training_batch')->nullable()->comment('For DLS');
            $table->integer('motivation_trip')->nullable()->comment('For DLS');
            $table->integer('educational_tour_batch')->nullable()->comment('For DLS');
            $table->integer('others_expansion_working_number')->nullable()->comment('For DLS');
            $table->decimal('total_cost',  $precision = 12, $scale = 2)->nullable()->comment('For DLS');
            $table->decimal('cost_by_cig',  $precision = 12, $scale = 2)->nullable()->comment('For DLS');
            $table->decimal('cost_by_project',  $precision = 12, $scale = 2)->nullable()->comment('For DLS');
            $table->string('implementation_period', 300)->nullable()->comment('For DLS');
            $table->string('officer_incharge')->nullable()->comment('For DLS');
            $table->text('comments')->nullable()->comment('For DLS');
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::drop('cig_microplans');
    }
}
