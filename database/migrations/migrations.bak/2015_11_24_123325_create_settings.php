<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettings extends Migration {

	public function up()
	{

		Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group')->nullable();
			$table->string('key')->nullable();            
            $table->string('name');
            $table->string('slug')->nullable();            
            $table->text('description')->nullable();
            $table->text('value')->nullable();
            $table->text('help_text')->nullable();   
            $table->string('input_type')->nullable();            
            $table->boolean('editable')->default();
            $table->integer('weight')->nullable();            
            $table->text('attributes')->nullable();            
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
		
	    Schema::drop('settings');
	}

}
