<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectProgressSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_progress_summary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('organization_id')
                    ->constrained('organizations')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('organogram_id')
                    ->nullable()
                    ->constrained('organograms')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('project_id')
                    ->nullable()
                    ->constrained('projects')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('division_id')
                    ->constrained('divisions')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('district_id')
                    ->constrained('districts')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->foreignId('upazila_id')
                    ->constrained('thana_upazilas')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
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
        Schema::dropIfExists('project_progress_summary');
    }
}
