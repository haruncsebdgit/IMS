<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAifFundAllocToolsTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aif_fund_alloc_tools_technologies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fund_allocation_id');  
            $table->unsignedBigInteger('tools_tech_goods_id');  
            $table->date('purchase_date');  
            $table->decimal('quantity',  $precision = 8, $scale = 2);  
            $table->unsignedBigInteger('unit_id')->nullable();  
            $table->date('operation_start_date')->nullable();  
            $table->text('technology_usage_other')->nullable();  
            $table->text('remarks')->nullable();  
            $table->timestamps();

            $table->foreign('fund_allocation_id')->references('id')->on('aif_fund_allocations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('tools_tech_goods_id')->references('id')->on('aif_tools_technologies')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('unit_id')->references('id')->on('common_labels')->onUpdate('cascade')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('aif_fund_alloc_tools_technologies');
        Schema::enableForeignKeyConstraints();
    }
}
