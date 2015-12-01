<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	public function up()
	{

		Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->nullable();            
            $table->text('description')->nullable();
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
		
	    Schema::drop('pages');
	}

}
