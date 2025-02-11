<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesWithBuyerInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_with_buyer_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();      
            $table->date('sale_date');
            $table->unsignedBigInteger('seed_multiplication_farm_name');
            $table->string('buyer_name');
            $table->unsignedBigInteger('sale_type');
            $table->unsignedBigInteger('buyer_type');
            $table->string('buyer_address');
            $table->unsignedBigInteger('type_of_person_purchase_fingerlings')->nullable();
            $table->string('buyer_mobile');
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
        Schema::dropIfExists('sales_with_buyer_information');
    }
}
