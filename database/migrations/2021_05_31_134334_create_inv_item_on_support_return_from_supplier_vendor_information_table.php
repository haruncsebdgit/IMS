<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvItemOnSupportReturnFromSupplierVendorInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_item_on_support_return_from_supplier_vendor_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->integer('on_support_id')->nullable();
            $table->date('receive_date')->nullable();
            $table->integer('inventory_cost_center')->nullable();
            $table->integer('supplier_vendor')->nullable();
            $table->text('return_from_remarks')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
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
        Schema::dropIfExists('inv_item_on_support_return_from_supplier_vendor_information');
    }
}
