<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTechnologyFiacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = [
            'technologies', 'fiacs'
        ];
        foreach ($table as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->unsignedBigInteger('organogram_id')->nullable()->after('organization_id');
                $table->unsignedBigInteger('project_id')->nullable()->after('organogram_id');

                $table->foreign('organogram_id')->references('id')->on('organograms')->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = [
            'technologies', 'fiacs'
        ];
        foreach ($table as $t) {
            Schema::table($t, function (Blueprint $table) {
                Schema::disableForeignKeyConstraints();
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
                if($table == 'technologies'){
                    // $table->dropForeign(['organogram_id']); 
                    // $table->dropForeign('technologies_organogram_id_foreign');
                    // $table->dropForeign(['project_id']); 
                    // $table->dropForeign('technologies_project_id_foreign');
                    
                    // DB::statement('DROP INDEX technologies_organogram_id_foreign ON technologies;');
                    // DB::statement('DROP INDEX technologies_project_id_foreign ON technologies;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `technologies` DROP constraint `technologies_organogram_id_foreign`;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `technologies` DROP column `organogram_id`;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `technologies` DROP constraint `technologies_project_id_foreign`;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `technologies` DROP column `project_id`;');
                    // $table->dropForeign('technologies_organogram_id_foreign');
                    // $table->dropForeign('technologies_project_id_foreign');
                }elseif($table == 'fiacs'){
                    // $table->dropForeign(['organogram_id']); 
                    // $table->dropForeign('fiacs_organogram_id_foreign');
                    // $table->dropForeign(['project_id']); 
                    // $table->dropForeign('fiacs_project_id_foreign');
                    // DB::statement('DROP INDEX fiacs_organogram_id_foreign ON fiacs;');
                    // DB::statement('DROP INDEX fiacs_project_id_foreign ON fiacs;');
                    // DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `fiacs` DROP FOREIGN KEY `fiacs_organogram_id_foreign`;');
                    // DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `fiacs` DROP FOREIGN KEY `fiacs_project_id_foreign`;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `fiacs` DROP constraint `fiacs_organogram_id_foreign`;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `fiacs` DROP column `organogram_id`;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `fiacs` DROP constraint `fiacs_project_id_foreign`;');
                    DB::statement('SET FOREIGN_KEY_CHECKS=0; ALTER TABLE `fiacs` DROP column `project_id`;');
                    // $table->dropForeign('fiacs_organogram_id_foreign');
                    // $table->dropForeign('fiacs_project_id_foreign');                
                }
                // $table->dropColumn(['organogram_id']);
                // $table->dropColumn(['project_id']);
                Schema::enableForeignKeyConstraints();
                // my table definitions go here
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            });
        }
    }
}
