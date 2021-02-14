<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration {

	public function up()
	{
		Schema::create('followers', function(Blueprint $table) {
			$table->timestamps();
            $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('followed_user_id')->unsigned();
			$table->index(['user_id', 'followed_user_id']);
		});
	}

	public function down()
	{
		Schema::drop('followers');
	}
}