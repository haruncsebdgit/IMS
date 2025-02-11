<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProducerOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producer_organizations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->string('name', 300);
            $table->text('address');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('registration_no');
            $table->date('registration_date');
            $table->date('registration_renew_date')->nullable();
            $table->tinyInteger('is_mmc_ccmc_hortex')->nullable();
            $table->string('mmc_bazar_name', 300)->nullable();
            $table->unsignedBigInteger('po_business_type_id')->nullable();
            $table->string('trade_license_no')->nullable();
            $table->date('trade_license_date')->nullable();
            $table->string('po_registration_attachment')->nullable();
            $table->string('mmc_trade_license_attachment')->nullable();

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::drop('producer_organizations');
    }
}
