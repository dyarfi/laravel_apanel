<?php namespace Tasks\Db;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks';

	/**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image'
    ];


    // a task is owned by a user
    public function user()
    {
        return $this->belongsTo('Tasks\Db\User','user_id','id');
    }

}
