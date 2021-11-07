<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255);
            $table->string('username_clean', 255)->unique();
            $table->string('email', 100)->unique();
            $table->string('ip', 40); // IP on registration
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 40);
            $table->timestamp('password_changed_at')->nullable();
            $table->tinyInteger('type')->default(0); // Type of user: [founder, admin, mod, user = null]
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->date('birthday')->nullable();
            $table->timestamp('last_visit')->nullable();
            $table->string('lang', 30)->nullable();
            $table->decimal('time_zone')->nullable();
            $table->unsignedTinyInteger('dst')->nullable(); // Daylight savings time
            $table->string('dateformat', 30)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->mediumText('signature_original')->nullable();
            $table->mediumText('signature_converted')->nullable();
            $table->boolean('show_images')->default(true);
            $table->boolean('show_signature')->default(true);
            $table->boolean('show_avatars')->default(true);
            $table->boolean('word_censoring')->default(true);
            $table->boolean('attach_signature')->default(false);
            $table->boolean('allow_bbcode')->default(true);
            $table->boolean('allow_notifications')->default(true);
            $table->boolean('allow_view_mail')->default(false);
            $table->boolean('allow_mass_email')->default(true);
            $table->boolean('allow_pm')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('rank_id')->references('id')->on('ranks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
