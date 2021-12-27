<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeForumColumnsNullableAndAddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forums', function ($table) {
            $table->unsignedBigInteger('parent')->nullable()->change();
            $table->foreign('parent')->references('id')->on('forums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forums', function ($table) {
            $table->dropForeign(['parent']);
            $table->integer('parent')->change();
        });
    }
}
