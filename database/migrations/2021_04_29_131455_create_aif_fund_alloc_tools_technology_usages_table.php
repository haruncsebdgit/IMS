<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAifFundAllocToolsTechnologyUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aif_fa_ttechnology_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tools_technology_id', 'fk_fund_allc_tt')->constrained('aif_fund_alloc_tools_technologies')->onUpdate('cascade')->onDelete('restrict');  
            $table->foreignId('tools_technology_usage_id')->constrained('aif_tools_technology_details')->onUpdate('cascade')->onDelete('restrict');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aif_fa_ttechnology_usages');
    }
}
