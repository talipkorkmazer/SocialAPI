<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('token')->unique()->nullable()->default(null);
			$table->string('email')->unique();
			$table->string('username')->unique();
			$table->string('password');
			$table->string('full_name')->nullable()->default(null);
			$table->string('bio')->nullable()->default(null);
			$table->string('profile_picture')->nullable()->default(null);
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}