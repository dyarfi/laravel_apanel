<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('careers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
            $table->string('slug')->nullable();            
            $table->text('description')->nullable();
            $table->text('attributes')->nullable();
            $table->text('options')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('status')->default(1);
            $table->nullableTimestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('careers');
	}

}
