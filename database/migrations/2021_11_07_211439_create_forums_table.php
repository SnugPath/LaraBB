<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->id();
            $table->integer('parent');
            $table->string('name', 255);
            $table->text('desc')->nullable();
            $table->string('password', 40)->nullable();
            $table->string('img', 255);
            $table->tinyInteger('topics_per_page');
            $table->tinyInteger('type'); // 0 = Category, 1 = Forum
            $table->tinyInteger('status');
            $table->unsignedBigInteger('last_post')->nullable(); // Foreign Key
            $table->unsignedBigInteger('last_author')->nullable();
            $table->boolean('display_on_index')->default(true);
            $table->boolean('display_indexed')->default(true);
            $table->boolean('display_icons')->default(true);
            $table->timestamps();

            $table->foreign('last_author')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
