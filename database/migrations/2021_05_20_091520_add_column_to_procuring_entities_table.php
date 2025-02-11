<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProcuringEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procuring_entities', function (Blueprint $table) {

            $table->string('category_head_procuring_entity')->nullable()->after('procuring_entity_head');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procuring_entities', function (Blueprint $table) {

            $table->dropColumn('category_head_procuring_entity');
            //
        });
    }
}
