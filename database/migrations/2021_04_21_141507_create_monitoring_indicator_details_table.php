<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringIndicatorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring_indicator_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('monitoring_indicator_id');
            $table->unsignedBigInteger('indicator_category_id')->nullable()->comment('DAE');
            $table->unsignedBigInteger('indicator_sub_category_id')->nullable()->comment('DAE');
            $table->unsignedBigInteger('cig_member_id')->nullable()->comment('DAE');
            $table->unsignedBigInteger('indicator_setup_id')->nullable()->comment('DAE');
            $table->string('at_present', 255)->nullable();
            $table->string('before', 255)->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->foreign('monitoring_indicator_id')->references('id')->on('monitoring_indicators')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('indicator_category_id')->references('id')->on('indicator_categories')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('indicator_sub_category_id')->references('id')->on('indicator_sub_categories')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('indicator_setup_id')->references('id')->on('indicator_setups')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('monitoring_indicator_details');
    }
}
