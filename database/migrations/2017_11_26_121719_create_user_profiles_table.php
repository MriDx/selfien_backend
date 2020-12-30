<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('image');
            $table->enum('gender', config('constants.enums.gender'));
            $table->string('fcm_registration_id')->nullable();
            $table->boolean('notification_on_like')->default(true);
            $table->boolean('notification_on_dislike')->default(true);
            $table->boolean('notification_on_comment')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_paid')->default(false);
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
        Schema::dropIfExists('user_profiles');
    }
}
