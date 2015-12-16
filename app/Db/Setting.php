<?php namespace App\Db;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model {

    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'settings';

	/**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',  
        'description',
        'value',
        'help_text',
        'status'
    ];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    // a task is owned by a user
    public function user()
    {
        return $this->belongsTo('App\Db\User','user_id','id');
    }

}
