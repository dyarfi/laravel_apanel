<?php namespace App\Db;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;    

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name','username','email','avatar','provider_id','provider','about','attributes','password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    /**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
	    'attributes'  => 'object',
	    'permissions' => 'array'
	    // 'is_admin' => 'boolean',
	];

	/**
	 * A user can have many tasks.
	 *
	 */
	public function tasks()
	{
		return $this->hasMany('App\Db\Task','user_id');
	}

	/**
	 * A user can have one roles.
	 *
	 */
	public function roles()
	{
		//return $this->hasOne('App\Db\RoleUser');
		return $this->belongsToMany('App\Db\Role','role_users');

	}
}
