<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFishingGearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fishing_gear', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('organogram_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('name_en');
            $table->string('name_bn');
            $table->string('common_name_en');
            $table->string('common_name_bn');
            $table->string('group_name_en');
            $table->string('group_name_bn');
            $table->unsignedBigInteger('fish_type_id');

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            //foreign
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('fish_type_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organogram_id')->references('id')->on('organograms')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');


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
        Schema::dropIfExists('fishing_gear');
    }
}
