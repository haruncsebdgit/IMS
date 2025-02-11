<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBeelIdInBeelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beel_details', function (Blueprint $table) {
            $table->foreignId('beel_id')
            ->unsigned()
            ->after('id')
            ->constrained('beel')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->enum('scope', ['balseline', 'assessment'])
             ->after('beel_id')
             ->nullable()
             ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beel_details', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('beel_details_beel_id_foreign');
            $table->dropColumn(['beel_id']);
            $table->dropColumn(['scope']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
