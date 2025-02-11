<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');

            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('procure_type_id');
            $table->unsignedBigInteger('procure_year');
            $table->unsignedBigInteger('method_type_id');
            $table->unsignedBigInteger('authority');
            
            $table->integer('serial_no')->nullable();
            $table->string('package_number')->nullable();
            $table->text('description')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('source')->nullable();
            $table->string('cost')->nullable();
            $table->decimal('contract_amount')->nullable();
            

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
        Schema::dropIfExists('packages');
    }
}
