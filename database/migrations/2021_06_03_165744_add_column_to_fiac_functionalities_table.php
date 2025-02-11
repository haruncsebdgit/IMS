<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToFiacFunctionalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiac_functionalities', function (Blueprint $table) {
           
            $table->unsignedBigInteger('saao_id')->nullable()->after('reporting_month');
            $table->decimal('total_number_of_ph_test')->nullable()->after('booklets_distributed_from_fiac');
            $table->decimal('total_number_of_do_test')->nullable()->after('total_number_of_ph_test');
            $table->decimal('total_number_of_nh3_test')->nullable()->after('total_number_of_do_test');
            $table->tinyInteger('registers_certificate_with_page_number')->nullable()->after('total_number_of_nh3_test');
            $table->tinyInteger('information_record_registers')->nullable()->after('registers_certificate_with_page_number');
            $table->tinyInteger('registers_updated_as_of_visiting_date')->nullable()->after('information_record_registers');
            $table->text('how_increase_number_of_farmers_take_service_in_fiac')->nullable()->after('registers_updated_as_of_visiting_date');
            $table->text('how_send_information_faster_through_ict')->nullable()->after('how_increase_number_of_farmers_take_service_in_fiac');

            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author')->after('how_send_information_faster_through_ict');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier')->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiac_functionalities', function (Blueprint $table) {

            $table->dropColumn(['saao_id', 'total_number_of_ph_test', 'total_number_of_do_test', 'total_number_of_nh3_test', 'registers_certificate_with_page_number', 'information_record_registers', 'registers_updated_as_of_visiting_date', 'how_increase_number_of_farmers_take_service_in_fiac', 'how_send_information_faster_through_ict', 'created_by', 'updated_by' ]);

        });
    }
}
