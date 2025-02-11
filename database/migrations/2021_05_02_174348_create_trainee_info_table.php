<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraineeInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainee_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('trainee_type');
            $table->string('name_en', 500);
            $table->string('name_bn', 500)->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_ethnic');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->enum('gender', ['male', 'female', 'third_gender']);
            $table->integer('age')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('nid');
            $table->string('mobile');
            $table->string('email');
            $table->text('training_information')->nullable();
            $table->integer('farm_area')->nullable();
            $table->string('trainee_image',500)->nullable();

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            // Relationship
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('designation_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('trainee_type')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('trainee_info');
    }
}
