<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('custom_field_types', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name', 255)->nullable(false);
            $table->string('description', 512)->nullable(true);
            $table->timestamps();
        });

        Schema::table('custom_field', function (Blueprint $table) {
            $table->unsignedBigInteger('type')->default(0)->change();
            $table->foreign('type')->references('id')->on('custom_field_types');
        });

        DB::table('custom_field_types')->insert(
            [
                'id' => 1,
                'name' => 'text',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_field', function (Blueprint $table) {
            $table->dropForeign(['type']);
            $table->unsignedBigInteger('type')->default(0)->change();
        });

        Schema::dropIfExists('custom_field_types');
    }
};
