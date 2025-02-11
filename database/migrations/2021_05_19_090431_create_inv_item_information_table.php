<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvItemInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_item_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->string('name_en', 500);
            $table->string('name_bn', 500)->nullable();
            $table->string('code_en', 100)->nullable();
            $table->string('code_bn', 100)->nullable();
            $table->integer('asset_type')->nullable();
            $table->integer('category_id');
            $table->integer('uom_id')->nullable();
            $table->integer('manufacturer_id')->nullable();          
            $table->text('model')->nullable();
            $table->text('part_number')->nullable();
            $table->integer('min_re_order_qty')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('is_serialized')->nullable();
            $table->integer('is_active')->nullable();
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
        Schema::dropIfExists('inv_item_information');
    }
}
