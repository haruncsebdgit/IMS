<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberOfParticipantsToNeccDeccUeccMeetingInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('necc_decc_uecc_meeting_information', function (Blueprint $table) {
            $table->unsignedBigInteger('number_of_participant')->nullable()->after('attachment');
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
            $table->dropColumn('number_of_participants');
        });
    }
}
