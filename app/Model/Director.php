<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Director extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'directors';

	protected $with = array('films');

	public static $rules = array
	(
		'first_name' => 'required',
		'last_name' => 'required',
		'salary' => 'required',
	);

	public function films()
	{
		return $this->hasMany('App\Model\Film');
	}

	public function getNameAttribute()
	{
		return $this->getAttribute('first_name') . ' ' . $this->getAttribute('last_name');
	}

	public function getFormattedSalaryAttribute()
	{
		return '$'.number_format($this->getAttribute('salary'), 2);
	}

	public function getNumFilmsAttribute()
	{
		return count($this->films);
	}
}