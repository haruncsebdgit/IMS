<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemonstrationPondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demonstration_ponds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('demonstration_id');
            $table->unsignedBigInteger('cig_member_detail_id');

            $table->foreign('demonstration_id')->references('id')->on('demonstrations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_detail_id')->references('id')->on('cig_member_details')->onUpdate('cascade')->onDelete('restrict');
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demonstration_ponds');
    }
}
