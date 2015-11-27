<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->text('description')->nullable();
			$table->tinyInteger('backend_access')->default(1);
			$table->tinyInteger('full_backend_access')->default(0);
			$table->tinyInteger('status')->default(1);
			$table->tinyInteger('is_system')->default(1);
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
		Schema::drop('user_groups');
	}

}
