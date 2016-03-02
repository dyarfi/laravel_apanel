<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'films';

	public static $rules = array
	(
		'name' => 'required',
		'release_date' => 'required',
		'director_id' => 'required',
	);

	public function director()
	{
		return $this->belongsTo('App\Model\Director');
	}

	public function actors()
	{
		return $this->belongsToMany('App\Model\Actor', 'actors_films');
	}

	public function theaters()
	{
		return $this->belongsToMany('App\Model\Theater', 'films_theaters');
	}

	public function boxOffice()
	{
		return $this->hasMany('App\Model\BoxOffice');
	}

	public function getDirectorNameAttribute()
	{
		return isset($this->director->name) ? $this->director->name : '';
	}
}