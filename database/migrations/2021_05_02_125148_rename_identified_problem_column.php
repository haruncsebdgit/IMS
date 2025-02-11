<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameIdentifiedProblemColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('identified_problems', function (Blueprint $table) {
            $table->renameColumn('identified_problem', 'list_of_identified_problem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('identified_problems', function (Blueprint $table) {
            $table->renameColumn('list_of_identified_problem', 'identified_problem');
        });
    }
}
