<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForDlsToProducerOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('producer_organizations', function (Blueprint $table) {
            $table->unsignedBigInteger('union_id')->nullable()->after('upazila_id')->comment('Only For DLS');
            $table->unsignedBigInteger('bank_name_id')->nullable()->after('email')->comment('Only For DLS');
            $table->string('bank_branch')->nullable()->after('bank_name_id')->comment('Only For DLS');
            $table->string('bank_account_title')->nullable()->after('bank_branch')->comment('Only For DLS');
            $table->string('bank_account_no')->nullable()->after('bank_account_title')->comment('Only For DLS');
            $table->decimal('saving_per_member_per_month', $precision = 8, $scale = 2)->nullable()->after('bank_account_no')->comment('Only For DLS');
            $table->tinyInteger('holding_monthly_meeting')->nullable()->after('saving_per_member_per_month')->comment('Only For DLS');
            
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('bank_name_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('producer_organizations', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['bank_name_id']);
            $table->dropForeign(['union_id']);

            $table->dropColumn(['holding_monthly_meeting']);
            $table->dropColumn(['saving_per_member_per_month']);
            $table->dropColumn(['bank_account_no']);
            $table->dropColumn(['bank_account_title']);
            $table->dropColumn(['bank_branch']);
            $table->dropColumn(['bank_name_id']);
            $table->dropColumn(['union_id']);
         
            Schema::enableForeignKeyConstraints();
        });
    }
}
