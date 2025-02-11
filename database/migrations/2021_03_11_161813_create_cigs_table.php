<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cigs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id');
            $table->string('cig_name', 300);
            $table->text('cig_address');
            $table->date('establish_date');
            $table->string('registration_no')->nullable();
            $table->string('registration_date')->nullable();
            $table->unsignedBigInteger('cig_grade')->nullable();
            $table->tinyInteger('is_applied_registration')->nullable();
            $table->unsignedBigInteger('bank_name_id')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->unsignedBigInteger('cig_category');
            $table->tinyInteger('is_generating_saving')->nullable();
            $table->decimal('saving_per_member_per_month',  $precision = 8, $scale = 2)->nullable();
            $table->date('registration_renew_date')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('union_id')->references('id')->on('union_wards')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('bank_name_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::drop('cigs');
    }
}
