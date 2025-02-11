<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTraderDistributerBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trader_distributer_buyers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id');
            $table->string('organization_name', 300);
            $table->text('address');
            $table->string('trader_name');
            $table->string('mobile', 50);
            $table->string('gender', 50);
            $table->string('nid', 50)->nullable();
            $table->string('trader_type')->nullable();
            $table->string('export_country')->nullable();
            $table->string('item_info')->nullable();
            $table->string('agent_of_export_company')->nullable();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->timestamps();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('upazila_id')->references('id')->on('thana_upazilas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('union_id')->references('id')->on('union_wards')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::drop('trader_distributer_buyers');
        Schema::enableForeignKeyConstraints();
    }
}
