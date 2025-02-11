<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::disableForeignKeyConstraints();

        DB::statement('
        CREATE TABLE `access_logs` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) unsigned NOT NULL,
            `login_ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
            `login_datetime` datetime NOT NULL,
            `logout_datetime` datetime NOT NULL,
            `user_agent` text COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        
        ');

        Schema::enableForeignKeyConstraints();
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_logs');
    }
}
