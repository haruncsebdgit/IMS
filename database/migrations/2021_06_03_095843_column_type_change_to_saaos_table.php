<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColumnTypeChangeToSaaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saaos', function (Blueprint $table) {
            $table->string('mobile_number')->nullable()->change();
            $table->unsignedBigInteger('educational_level')->nullable()->change();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saaos', function (Blueprint $table) {
            $table->bigInteger('mobile_number')->nullable()->change();
            $table->text('educational_level')->nullable()->change();
        });
    }
}
