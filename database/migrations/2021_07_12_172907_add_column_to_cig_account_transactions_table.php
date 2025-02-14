<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCigAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cig_account_transactions', function (Blueprint $table) {
           /* $table->unsignedBigInteger('transaction_type_id')->nullable()->change();
            $table->unsignedBigInteger('deposite_type_id')->nullable()->change();
            $table->string('field_of_investment', 300)->nullable()->change();
            $table->date('date_of_transaction')->nullable()->change();
            $table->decimal('amount',  $precision = 12, $scale = 2)->nullable()->change();

            $table->decimal('opening_balance', 12, 2)->nullable()->after('amount')->comment('For DLS');
            $table->foreignId('financial_year_id')
                ->nullable()->comment('Only for DLS')->after('opening_balance')
                ->constrained('financial_years')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->date('transaction_month')->nullable()->after('financial_year_id')->comment('For DLS');
            $table->decimal('deposit_member_savings', 12, 2)->nullable()->after('transaction_month')->comment('For DLS');
            $table->decimal('deposit_recovery_of_investment', 12, 2)->nullable()->after('deposit_member_savings')->comment('For DLS');
            $table->decimal('deposit_profit_interest', 12, 2)->nullable()->after('deposit_recovery_of_investment')->comment('For DLS');
            $table->decimal('deposit_others', 12, 2)->nullable()->after('deposit_profit_interest')->comment('For DLS');
            $table->decimal('withdraw_investment', 12, 2)->nullable()->after('deposit_others')->comment('For DLS');
            $table->decimal('withdraw_saving_returned', 12, 2)->nullable()->after('withdraw_investment')->comment('For DLS');
            $table->decimal('withdraw_profit_distribution', 12, 2)->nullable()->after('withdraw_saving_returned')->comment('For DLS');
            $table->decimal('withdraw_others', 12, 2)->nullable()->after('withdraw_profit_distribution')->comment('For DLS');*/

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cig_account_transactions', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->unsignedBigInteger('transaction_type_id')->change();
            $table->unsignedBigInteger('deposite_type_id')->change();
            $table->string('field_of_investment', 300)->change();
            $table->date('date_of_transaction')->change();
            $table->decimal('amount',  $precision = 12, $scale = 2)->change();

            $table->dropForeign('cig_account_transactions_financial_year_id_foreign');
            $table->dropColumn(['opening_balance', 'financial_year_id', 'transaction_month', 'deposit_member_savings']);
            $table->dropColumn(['deposit_recovery_of_investment', 'deposit_profit_interest', 'deposit_others', 'withdraw_investment']);
            $table->dropColumn(['withdraw_saving_returned', 'withdraw_profit_distribution', 'withdraw_others']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
