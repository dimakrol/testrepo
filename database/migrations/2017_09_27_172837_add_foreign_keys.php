<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('tag_video', function (Blueprint $table) {
            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tag_video', function (Blueprint $table) {
            $table->dropForeign('tag_video_video_id_foreign');
            $table->dropForeign('tag_video_tag_id_foreign');
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign('videos_user_id_foreign');
        });
    }
}
