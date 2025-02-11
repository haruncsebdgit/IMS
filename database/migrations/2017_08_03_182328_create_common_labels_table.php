<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_labels', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('data_type', 255)->comment('type of data used to categorize content');
            $table->string('name',255);
            $table->string('name_bn', 300)->nullable();
            $table->integer('order')->nullable()->unsigned();
            $table->boolean('status')->default(true);

            $table->bigInteger('created_by')->nullable()->unsigned()->comment('author');
            $table->bigInteger('updated_by')->nullable()->unsigned()->comment('modifier');

            $table->timestamps();

            // index
            $table->index(['data_type', 'status', 'created_at', 'id'], 'type_status_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('common_labels');
        Schema::enableForeignKeyConstraints();
    }
}
