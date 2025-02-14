<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cigs', function (Blueprint $table) {
           /* $table->foreignId('dls_cig_category_id')
                ->nullable()->comment('Only for DLS')->after('cig_category')
                ->constrained('common_labels')
                ->onUpdate('cascade')
                ->onDelete('restrict');*/

        //    $table->tinyInteger('holding_monthly_meeting')->nullable()->after('dls_cig_category_id')->comment('For DLS');
         //   $table->decimal('total_investment', 12, 2)->nullable()->after('holding_monthly_meeting')->comment('For DLS');
        //    $table->decimal('total_savings', 12, 2)->nullable()->after('total_investment')->comment('For DLS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cigs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropForeign('cigs_dls_cig_category_id_foreign');
            $table->dropColumn(['dls_cig_category_id', 'holding_monthly_meeting', 'total_investment', 'total_savings']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
