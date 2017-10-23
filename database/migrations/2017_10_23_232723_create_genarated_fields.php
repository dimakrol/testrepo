<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenaratedFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generated_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('generated_id')->nullable();
            $table->string('name');
            $table->string('value');

            $table->foreign('generated_id')->references('id')->on('videos_generated')->onDelete('cascade');

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
        Schema::dropIfExists('generated_fields');
    }
}
