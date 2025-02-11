<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->bigInteger('organization_id');
            $table->bigInteger('technology_type_id')->nullable()->unsigned();
            $table->string('name_en',255);
            $table->string('name_bn',255);
            $table->string('code')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('order')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            // $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            // $table->foreign('technology_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technologies');
    }
}
