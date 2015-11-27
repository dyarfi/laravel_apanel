<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');			
			$table->string('name');
			$table->string('username')->nullable();
	        $table->string('email')->nullable();
	        $table->string('avatar')->nullable();
	        $table->string('provider')->default('email');
	        $table->string('provider_id')->nullable()->unique();
			$table->string('about', 1000)->nullable();
			$table->string('password', 60);
			$table->rememberToken();
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
		Schema::drop('users');
	}
	public function up () {
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('activation_code')->after('password');
			$table->integer('active')->default(0)->after('activation_code');
		});
	}

}
