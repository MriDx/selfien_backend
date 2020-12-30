<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_profile_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->enum('type', config('constants.enums.post_activities'));
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_profile_id')->references('id')->on('user_profiles')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_activities');
    }
}
