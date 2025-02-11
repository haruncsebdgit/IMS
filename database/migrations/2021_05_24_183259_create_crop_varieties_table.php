<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCropVarietiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_varieties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->bigIncrements('id');
            $table->foreignId('organization_id')
                    ->nullable()
                    ->constrained('organograms')
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
            $table->foreignId('crop_id')
                    ->constrained('common_labels')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->integer('crop_type_id')->nullable();
            $table->string('name_en', 300);
            $table->string('name_bn', 300);
            $table->foreignId('unit_id')
                    ->nullable()
                    ->constrained('common_labels')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->integer('crop_lifetime_id')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('crop_varieties');
    }
}
