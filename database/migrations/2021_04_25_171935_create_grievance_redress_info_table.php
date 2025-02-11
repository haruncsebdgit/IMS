<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrievanceRedressInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grievance_redress_info', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id')->nullable();
            $table->unsignedBigInteger('organization_id');
            $table->string('complainer_name');
            $table->unsignedBigInteger('complaint_received_location_id')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('financial_year_id')->nullable();
            $table->string('complaint_date')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('means_of_receive_complaint_id')->nullable();
            $table->enum('gender', ['male', 'female', 'third_gender'])->nullable();
            $table->unsignedBigInteger('complaint_subject_id')->nullable();
            $table->text('grievance_description')->nullable();
            $table->string('resolve_action_date')->nullable();
            $table->text('taken_action_for_resolve')->nullable();
            $table->unsignedBigInteger('solving_approach_id')->nullable();
            $table->integer('present_office_id')->nullable();
            $table->integer('previous_office_id')->nullable();
            $table->string('status')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

           

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
         
            //foreign relations
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('complaint_received_location_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('means_of_receive_complaint_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('complaint_subject_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('solving_approach_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->onUpdate('cascade')->onDelete('restrict');

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
        Schema::dropIfExists('grievance_redress_info');
    }
}
