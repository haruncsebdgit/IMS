<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('division_id')->unsigned();
            $table->string('name', 255);
            $table->string('name_bn', 255)->nullable();
            $table->string('geo_code', 10);
            $table->string('latitude', 100)->nullable();
            $table->string('longitude',100)->nullable();
            $table->boolean('is_active')->default(1);

            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            // relationship
            $table->foreign('division_id')->references('id')->on('divisions');


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
        Schema::dropIfExists('districts');
    }
}
