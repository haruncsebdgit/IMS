<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCigAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cig_account_transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cig_id');
            $table->unsignedBigInteger('transaction_type_id');
            $table->unsignedBigInteger('deposite_type_id');
            $table->string('field_of_investment', 300);
            $table->date('date_of_transaction');
            $table->decimal('amount',  $precision = 12, $scale = 2);
            $table->text('remarks')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::drop('cig_account_transactions');
    }
}
