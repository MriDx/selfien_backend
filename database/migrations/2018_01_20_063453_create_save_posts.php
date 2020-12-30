<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_posts', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('post_id')->unsigned();

            /*
             * Add Foreign/Unique/Index
             */
            $table->foreign('user_id', 'save_foreign_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('post_id', 'save_foreign_post')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->unique(['user_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('save_posts', function (Blueprint $table) {
            $table->dropForeign('save_foreign_user');
            $table->dropForeign('save_foreign_post');
        });

        /*
         * Drop tables
         */
        Schema::dropIfExists('users_roles');
    }
}
