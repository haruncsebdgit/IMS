<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcurementTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');

            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->string('name_en')->nullable();
            $table->string('name_bn')->nullable();
            $table->integer('weight')->nullable();
            $table->enum('is_default', ['yes', 'no'])->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->text('description')->nullable();

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('restrict')->onUpdate('cascade');

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
        Schema::dropIfExists('procurement_types');
    }
}
