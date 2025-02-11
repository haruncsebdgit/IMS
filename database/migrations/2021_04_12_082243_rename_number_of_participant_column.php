<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNumberOfParticipantColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('necc_decc_uecc_meeting_information', function (Blueprint $table) {
            $table->renameColumn('number_of_participant', 'number_of_participants');
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
            $table->renameColumn('number_of_participants', 'number_of_participant');
        });
    }
}
