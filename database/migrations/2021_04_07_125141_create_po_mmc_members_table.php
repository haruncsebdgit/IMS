<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePoMmcMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_mmc_members', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('po_id');
            $table->unsignedBigInteger('cig_member_id');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('organization_id')->nullable()->comment('Organization Id');
            $table->string('mobile', 20);
            $table->string('nid', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->unsignedBigInteger('educational_qualification_id')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('joining_date')->nullable();
            $table->date('release_resigned_date')->nullable();
            $table->string('gender')->nullable();
            $table->tinyInteger('is_mmc_member')->nullable();
            $table->unsignedBigInteger('mmc_designation_id')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('po_id')->references('id')->on('producer_organizations')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('educational_qualification_id')->references('id')->on('common_labels')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('po_mmc_members');
    }
}
