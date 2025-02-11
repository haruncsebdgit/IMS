<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnionWardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('union_wards', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('thana_upazila_id')->unsigned()->nullable();
            $table->enum('type', ['Union', 'City Corporation', 'Municipality']);
            $table->bigInteger('city_corp_municipality_id')->unsigned()->nullable();
            $table->string('name_en', 255);
            $table->string('name_bn', 255)->nullable();
            $table->string('geo_code', 10)->nullable();
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->boolean('is_active')->default(1);

            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            // relationship
            $table->foreign('thana_upazila_id')->references('id')->on('thana_upazilas');

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
        Schema::dropIfExists('union_wards');
    }
}
