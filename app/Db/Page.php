<?php namespace Tasks\Db;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model {

    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	/**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'permissions',
        'description'
    ];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    public function users()
    {
        //$this->belongsToMany('App\Role', 'user_roles', 'user_id', 'foo_id');
        //return $this->belongsToMany('Tasks\Db\User','role_users', 'role_id', 'user_id');
    }

}
