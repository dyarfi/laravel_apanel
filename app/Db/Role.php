<?php namespace App\Db;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {

    // Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

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

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array'
        // 'is_admin' => 'boolean',
    ];

    public function users()
    {
        //$this->belongsToMany('App\Role', 'user_roles', 'user_id', 'foo_id');
        return $this->belongsToMany('App\Db\User','role_users', 'role_id', 'user_id');
    }

}
