<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeWormingCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('de_worming_campaigns', function (Blueprint $table) {
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
            $table->unsignedBigInteger('cig_id');

            $table->date('campaign_date')->nullable();
            $table->string('campaign_place')->nullable();
            $table->integer('benefited_farmer')->nullable();
            $table->integer('benefited_female_farmer')->nullable();
            $table->integer('benefited_ethnic_farmer')->nullable();
            $table->integer('benefited_ethnic_female_farmer')->nullable();
            $table->integer('folder_leaflet_poster')->nullable();
            $table->integer('cattle_buffalo')->nullable();
            $table->integer('goat_sheep')->nullable();
            $table->integer('poultry_duck')->nullable();
            

            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->foreign('cig_id')->references('id')->on('cigs')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('financial_years_id')->references('id')->on('financial_years')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('de_worming_campaigns');
    }
}
