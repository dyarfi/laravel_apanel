<?php namespace App\Db;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model {
   
    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

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
        'slug',
        'description',
        'image',
        'user_id'
    ];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        //'editable'    => 'boolean',
        //'attributes'  => 'object',
        //'status'      => 'boolean'
    ];

    // a task is owned by a user
    public function user()
    {
        return $this->belongsTo('App\Db\User','user_id','id');
    }

    // Scope query for slug field
    public function scopeSlug($query, $string) {

        return $query->where('slug', $string)->firstOrFail();

    }

}
