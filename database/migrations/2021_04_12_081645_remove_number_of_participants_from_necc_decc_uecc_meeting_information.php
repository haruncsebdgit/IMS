<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNumberOfParticipantsFromNeccDeccUeccMeetingInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('necc_decc_uecc_meeting_information', function (Blueprint $table) {
            $table->dropColumn('number_of_participants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('necc_decc_uecc_meeting_information', function (Blueprint $table) {
            $table->decimal('number_of_participants' , $precision = 12, $scale = 2)->nullable();
        });
    }
}
