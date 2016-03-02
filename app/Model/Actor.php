<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actor extends Model {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'actors';


	public static $rules = array
	(
		'first_name' => 'required',
		'last_name' => 'required',
		'birth_date' => 'required',
	);

	public function films()
	{
		return $this->belongsToMany('App\Model\Film', 'actors_films');
	}

	public function getFormattedBirthDateAttribute()
	{
		return date('Y-m-d', strtotime($this->getAttribute('birth_date')));
	}

	public function getNameAttribute()
	{
		return $this->getAttribute('first_name').' '.$this->getAttribute('last_name');
	}
}