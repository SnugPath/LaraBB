<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_data_log', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('custom_field_id');
            $table->mediumText('content');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('custom_field_id')->references('id')->on('custom_field');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_field_data_log');
    }
};
