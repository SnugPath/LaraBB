<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forum_id');
            $table->boolean('approved')->default(true);
            $table->boolean('reported')->default(false);
            $table->string('title', 255);
            $table->mediumInteger('views');
            $table->tinyInteger('status');
            $table->tinyInteger('type');
            $table->timestamps();

            $table->foreign('forum_id')->references('id')->on('forums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
