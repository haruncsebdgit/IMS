<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saaos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id');
            $table->string('select_fiac');
            $table->text('name_of_saao', 255);
            $table->string('gender')->nullable();
            $table->string('is_ethnic')->nullable();
            $table->string('name_of_ethnic_group', 255)->nullable();
            $table->text('village', 255)->nullable();
            $table->string('nid')->nullable();
            $table->bigInteger('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('sim_no')->nullable();
            $table->string('bank_account')->nullable();
            $table->bigInteger('avarage_monthly_income_as_saao')->nullable();
            $table->text('educational_level')->nullable();
            $table->text('number_of_pond')->nullable(); 
            $table->decimal('area',  $precision = 8, $scale = 2)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('saaos');
    }
}
