<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMaintainingRecordOfProcurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maintaining_record_of_procurements', function (Blueprint $table) {

            $table->decimal('retention_money')->nullable()->after('performance_security_return_date');
            $table->date('retention_money_return_date')->nullable()->after('retention_money');
            $table->date('bank_guarantee_expiry_date')->nullable()->after('retention_money_return_date');
            $table->date('defective_liability_date')->nullable()->after('bank_guarantee_expiry_date');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maintaining_record_of_procurements', function (Blueprint $table) {

            $table->dropColumn('retention_money');
            $table->dropColumn('retention_money_return_date');
            $table->dropColumn('bank_guarantee_expiry_date');
            $table->dropColumn('defective_liability_date');

        });
    }
}
