<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meta', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->nullable(0)->unsigned();
            $table->string('meta_key', 255);
            $table->longText('meta_value')->nullable();

            // relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // index
            $table->index('user_id');
            $table->index('meta_key');

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
        Schema::dropIfExists('user_meta');
    }
}
