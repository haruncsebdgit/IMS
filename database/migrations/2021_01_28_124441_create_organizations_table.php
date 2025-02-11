<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en', 500);
            $table->string('name_bn', 500)->nullable();
            $table->string('short_name', 10)->nullable();
            $table->text('address');
            $table->string('phone', 30)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('web_address', 50)->nullable();
            $table->longText('comment', 50)->nullable();
            $table->string('logo',500)->nullable();
            $table->boolean('is_active')->default(1);

            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
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
        Schema::dropIfExists('organizations');
    }
}
