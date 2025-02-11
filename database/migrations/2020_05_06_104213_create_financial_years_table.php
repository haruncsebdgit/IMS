<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_years', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('year_name');
            $table->date('start_date');
            $table->date('end_date');

            $table->integer('sort_order')->nullable()->unsigned();
            $table->boolean('is_active')->default(1)->nullable();

            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->timestamps();

            // relationship
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

            // index
            $table->index(['year_name', 'is_active', 'created_at', 'id'], 'year_name_is_active_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_years');
    }
}
