<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCigMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cig_members', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cig_id');
            $table->string('member_name', 300);
            $table->enum('gender', ['male', 'female', 'third_gender']);
            $table->tinyInteger('is_ethnic');
            $table->unsignedBigInteger('ethnic_community_id')->nullable();
            $table->string('father_name', 300);
            $table->string('mother_name', 300);
            $table->string('spouse_name', 300)->nullable();
            $table->string('village', 300)->nullable();
            $table->unsignedBigInteger('cig_designation_id')->nullable();
            $table->string('bank_account')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nid');
            $table->unsignedBigInteger('resource_type')->nullable();
            $table->unsignedBigInteger('resource_sub_type')->nullable();
            $table->string('mobile_no')->nullable();

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->foreign('cig_id')->references('id')->on('cigs')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::drop('cig_members');
    }
}
