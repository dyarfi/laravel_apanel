<?php namespace App\Db;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'role_users';

	/**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'permissions'
    ];

    public function users()
    {
        //$this->belongsToMany('App\Role', 'user_roles', 'user_id', 'foo_id');
        return $this->belongsToMany('App\Db\User');
    }

}
