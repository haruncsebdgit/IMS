<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterImplementedVisitInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('implemented_visit_info', function (Blueprint $table) {

            $table->integer('num_of_farmer_participated')->after('number_of_female_farmer')->nullable();
            $table->integer('num_of_male_farmer_participated')->after('num_of_farmer_participated')->nullable();
            $table->integer('num_of_farmer_know_about_tech')->after('num_of_male_farmer_participated')->nullable();
            $table->text('justification_for_select_place')->after('num_of_farmer_interseted_about_exhibited_tech')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('implemented_visit_info', function (Blueprint $table) {
            $table->dropColumn(['num_of_farmer_participated',
            'num_of_male_farmer_participated', 'num_of_farmer_know_about_tech',
            'justification_for_select_place']);
        });
    }
}
