<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('author');
            $table->string('author_ip', 40);
            $table->boolean('approved')->default(true);
            $table->boolean('reported')->default(false);
            $table->text('content');
            $table->string('edit_reason', 255);
            $table->tinyInteger('edit_count')->default(0);
            $table->unsignedBigInteger('edit_user');
            $table->timestamps();

            $table->foreign('topic_id')->references('id')->on('topics');
            $table->foreign('author')->references('id')->on('users');
            $table->foreign('edit_user')->references('id')->on('users');
        });

        Schema::table('forums', function (Blueprint $table) {
            $table->foreign('last_post')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
