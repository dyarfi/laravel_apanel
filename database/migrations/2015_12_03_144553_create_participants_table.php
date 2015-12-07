<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participants', function(Blueprint $table)
		{
			$table->increments('id');			
			$table->string('provider_id',64)->nullable()->unique();
			$table->string('provider',32)->default('email');
	        $table->string('profile_url',256)->nullable();
	        $table->string('photo_url',256)->nullable();			
			$table->string('name')->nullable();
			$table->string('username')->nullable();
	        $table->string('email')->nullable();	        
			$table->string('password', 60)->nullable();
	        $table->string('avatar')->nullable();
			$table->string('about', 1000)->nullable();
			$table->string('phone_number', 32)->nullable();			
			$table->string('phone_home', 32)->nullable();			
			$table->string('address', 214)->nullable();			
			$table->string('region', 8)->nullable();
			$table->string('province', 8)->nullable();
			$table->string('urban_district', 8)->nullable();
			$table->string('sub_urban', 8)->nullable();
			$table->string('zip_code', 8)->nullable();			
			$table->string('website', 72)->nullable();
			$table->string('gender', 12)->nullable();
			$table->tinyInteger('age')->nullable()->unsigned();
			$table->string('nationality', 24)->nullable();
			$table->string('id_number', 32)->nullable();						
			$table->string('file_name', 512)->nullable();			
			$table->string('verify', 8)->nullable();			
			$table->tinyInteger('completed')->nullable()->unsigned();
			$table->tinyInteger('logged_in')->nullable()->unsigned();	
			$table->integer('last_login')->nullable()->unsigned();
			$table->string('session_id')->nullable();						
			$table->timestamp('join_date')->nullable();	
			$table->tinyInteger('status')->default(0)->unsigned();	
			$table->rememberToken();
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
		//
	}

}
