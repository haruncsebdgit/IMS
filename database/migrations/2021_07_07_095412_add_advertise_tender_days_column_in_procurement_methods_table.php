<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdvertiseTenderDaysColumnInProcurementMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procurement_methods', function (Blueprint $table) {
            $table->integer('advertise_tender_days')->nullable()->after('approval_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procurement_methods', function (Blueprint $table) {
            $table->dropColumn('advertise_tender_days');
        });
    }
}
