<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeedPreservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seed_preservations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->unsignedBigInteger('union_id');
            $table->unsignedBigInteger('financial_years_id');
            $table->unsignedBigInteger('season_id');
            $table->unsignedBigInteger('crop_name_id');
            $table->unsignedBigInteger('species_name_id');

            $table->integer('number_of_farmers')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('distributed')->nullable();
            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('seed_preservations');
    }
}
