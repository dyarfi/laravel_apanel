<?php namespace App\Db;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Participant extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;    

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'participants';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'provider_id',
			'provider',
			'profile_url'
			'photo_url'
			'name',
			'username',
			'email',
			'password'
			'avatar',
			'about',
			'phone_number',
			'phone_home',
			'address',
			'region',
			'province',
			'urban_district',
			'sub_urban',
			'zip_code',
			'website',
			'gender',
			'age',
			'nationality',
			'id_number',
			'file_name',
			'verify',
			'completed',
			'logged_in',
			'last_login',
			'session_id',
			'join_date',
			'status'
			];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

}
