<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('followers', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('followers', function(Blueprint $table) {
			$table->foreign('followed_user_id')->references('id')->on('users')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('posts', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('no action')
						->onUpdate('no action');
		});
        Schema::table('likes', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
        Schema::table('likes', function(Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
	}

	public function down()
	{
		Schema::table('followers', function(Blueprint $table) {
			$table->dropForeign('followers_user_id_foreign');
		});
		Schema::table('followers', function(Blueprint $table) {
			$table->dropForeign('followers_followed_user_id_foreign');
		});
		Schema::table('posts', function(Blueprint $table) {
			$table->dropForeign('posts_user_id_foreign');
		});
        Schema::table('likes', function(Blueprint $table) {
            $table->dropForeign('likes_user_id_foreign');
        });
        Schema::table('posts', function(Blueprint $table) {
            $table->dropForeign('likes_post_id_foreign');
        });
	}
}