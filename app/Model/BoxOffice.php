<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoxOffice extends Model {

	protected $table = 'box_offices';

	public static $rules = array
	(
		'revenue' => 'required|numeric',
		'film_id' => 'required|integer',
		'theater_id' => 'required|integer',
	);

	public function film()
	{
		return $this->belongsTo('App\Model\Film');
	}

	public function theater()
	{
		return $this->belongsTo('App\Model\Theater');
	}

	public function getFormattedRevenueAttribute()
	{
		return '$'.number_format($this->getAttribute('revenue'), 2);
	}
}