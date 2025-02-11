<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en', 255);
            $table->string('name_bn', 255)->nullable();

            $table->string('employee_image', 500)->nullable();
            $table->bigInteger('designation_id')->unsigned()->nullable()->comment('From Common Labels: Designation');
            $table->bigInteger('organogram_id')->unsigned();

            $table->string('father_name', 255)->nullable();
            $table->string('mother_name', 255)->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('mobile', 15)->nullable();
            $table->string('nid', 20)->nullable();
            $table->string('email', 255)->nullable();

            $table->string('gender', 20)->nullable();
            $table->string('religion', 15)->nullable();
            $table->date('joining_date')->nullable();

            $table->date('retirement_date')->nullable();
            $table->bigInteger('employee_type_id')->unsigned()->nullable()->comment('From Common Labels: Employee Type');
            $table->bigInteger('employee_category_id')->unsigned()->nullable()->comment('From Common Labels: Employee Category');
           
            $table->bigInteger('employee_class_id')->unsigned()->nullable()->comment('From Common Labels: Employee Class');
            $table->boolean('is_active')->default(1);
            $table->longText('address', 50)->nullable();

            $table->bigInteger('division_id')->unsigned()->nullable()->comment('From Divisions');
            $table->bigInteger('district_id')->unsigned()->nullable()->comment('From Districts');
            $table->bigInteger('upazila_id')->unsigned()->nullable()->comment('From Thana/Upazila');

            $table->bigInteger('union_id')->unsigned()->nullable()->comment('From Union/Ward');
            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
           
            // Relationship.
            $table->foreign('designation_id')->references('id')->on('common_labels')->onDelete('restrict');
            $table->foreign('organogram_id')->references('id')->on('organograms');
            $table->foreign('employee_type_id')->references('id')->on('common_labels')->onDelete('restrict');
            
            $table->foreign('employee_category_id')->references('id')->on('common_labels')->onDelete('restrict');
            $table->foreign('employee_class_id')->references('id')->on('common_labels')->onDelete('restrict');
            $table->foreign('division_id')->references('id')->on('divisions');

            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas');
            $table->foreign('union_id')->references('id')->on('union_wards');

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

            // index
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
