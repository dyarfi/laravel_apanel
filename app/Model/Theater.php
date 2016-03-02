<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theater extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'theaters';

	public static $rules = array
	(
		'name' => 'required',
	);

	public function films()
	{
		return $this->belongsToMany('App\Model\Film', 'films_theaters');
	}

	public function boxOffice()
	{
		return $this->hasMany('App\Model\BoxOffice');
	}
}