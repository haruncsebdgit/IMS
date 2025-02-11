<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCigProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cig_productions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cig_id');
            $table->unsignedBigInteger('cig_member_id');
            $table->unsignedBigInteger('financial_year_id');
            $table->date('entry_date');
            $table->string('production_area')->nullable()->comment('For DAE');
            $table->unsignedBigInteger('demonstrated_technology_id');
            $table->integer('number_of_stocked');
            $table->integer('duration')->nullable();
            $table->decimal('total_production', $precision = 12, $scale = 2);
            $table->decimal('total_cost', $precision = 12, $scale = 2)->nullable()->comment('In taka');
            $table->decimal('total_income', $precision = 12, $scale = 2)->nullable()->comment('In taka');
            $table->decimal('fcr', $precision = 12, $scale = 2)->nullable();
            $table->unsignedBigInteger('used_technology_id')->comment('For DOF');
            $table->unsignedBigInteger('yield')->nullable()->comment('For DOF');
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('used_technology_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::drop('cig_productions');
    }
}
