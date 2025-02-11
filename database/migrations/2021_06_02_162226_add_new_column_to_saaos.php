<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToSaaos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saaos', function (Blueprint $table) {
            $table->tinyInteger('is_active')->default(0)->after('date_of_birth');
            $table->unsignedBigInteger('name_of_ethnic_group_id')->nullable()->after('is_ethnic');
            $table->unsignedBigInteger('fiac_id')->nullable()->after('name_of_saao');


            $table->foreignId('organogram_id')
            ->nullable()->after('id')
            ->constrained('organograms')
            ->onUpdate('cascade')
            ->onDelete('restrict');
           $table->foreignId('project_id')
            ->nullable()->after('organogram_id')
            ->constrained('projects')
            ->onUpdate('cascade')
            ->onDelete('restrict');


            $table->dropColumn(['select_fiac', 'name_of_ethnic_group' ]);


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

            Schema::disableForeignKeyConstraints();
            $table->dropForeign('saaos_organogram_id_foreign');
            $table->dropForeign('saaos_project_id_foreign');
            $table->dropColumn(['organogram_id', 'project_id', 'is_active', 'name_of_ethnic_group_id','fiac_id' ]);
            Schema::enableForeignKeyConstraints();

            $table->string('select_fiac')->after('union_id');
            $table->string('name_of_ethnic_group', 255)->nullable()->after('is_ethnic');
        });
    }
}
