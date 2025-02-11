<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganogramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organograms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->integer('parent_id');
            $table->string('name_en', 500);
            $table->string('name_bn', 500)->nullable();
            $table->string('office_type', 100);
            $table->unsignedBigInteger('division_region_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('upazila_id')->nullable();
            $table->string('code', 100)->nullable()->nullable();
            $table->text('address');
            $table->string('phone', 50);
            $table->string('fax', 100)->nullable();
            $table->tinyInteger('is_active');
            $table->tinyInteger('is_inventory_center');
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            // Relationship
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('organograms');
    }
}
