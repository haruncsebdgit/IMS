<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCigMemberDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cig_member_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cig_member_id');
            $table->string('pond_name_number', 300)->nullable()->comment('For DOF');
            $table->decimal('water_area',  $precision = 8, $scale = 2)->nullable()->comment('For DOF');
            $table->unsignedBigInteger('used_technology_id')->nullable()->comment('For DOF');
            $table->unsignedBigInteger('animal_type_id')->nullable()->comment('For DLS');
            $table->unsignedBigInteger('breed_type_id')->nullable()->comment('For DLS');
            $table->integer('number_of_animal')->nullable()->comment('For DLS');

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
            $table->foreign('cig_member_id')->references('id')->on('cig_members')->onUpdate('cascade')->onDelete('restrict');
           
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
        Schema::dropIfExists('cig_member_details');
    }
}
