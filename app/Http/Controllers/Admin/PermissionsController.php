<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Auth, Session, Redirect, Input, View;
// Load Sentinel and Socialite classes
use Sentinel, Socialite;
// Load other classes
use App\Http\Controllers\Admin\BaseAdmin;
// Load main models
use App\Db\User, App\Db\Role, App\Db\Task;

class PermissionsController extends BaseAdmin {

	/**
	 * Holds the Sentinel permissions repository.
	 *
	 * @var \Cartalyst\Sentinel\permissions\EloquentRole
	 */
	protected $permissions;

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
		// Parent constructor
		parent::__construct();
		
		// Load Http/Middleware/Admin controller
		$this->middleware('auth.admin');

		$this->permissions  = Sentinel::getRoleRepository();
		$this->users 		= Sentinel::getUserRepository();
	}

	/**
	 * Display a listing of permissions.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		
		$permissions = Role::all();
		
		//$permissions->each(function($value) {
			//$value->permissions = json_decode($value->permissions,true);
			//return $value;
		//});
		
		$data = ['permissions'=>$permissions];

		return $this->view('admin.sentinel.permissions.index')->data($data)->title('Permission Listing');
	}


	public function change($id=null) {
		
		// Default variable checking
		$updated = false;	    

	    // Check if requested contain 'access_permission'
		if (Request::has('user_form')) {
						
			// Get user model
	    	$user = Sentinel::getUserRepository()->findById($id);		

			// Check if value posted is not empty and array valued
			if (is_array(Request::input('access_permission'))) {

				// Reset database column
				unset($user->permissions);

				// Set Role Permissions
				foreach (Request::input('access_permission') as $permission => $value) {
					$user->updatePermission($permission, ($value) ? true : false, true)->save();
				}

			} else {

				// Set empty permission
				//unset($user->permissions);
				//$user->removePermission('*.*')->save();
				$user->permissions = [];

				
				// Save user data
				$user->save();

				//dd ($user->permissions);
				

			}


			// Saved checking
			$updated = true;

		} else 
		// Check if requested contain 'access_permission'
		if (Request::has('role_form')) {

			// Get user model
	    	$role = Sentinel::findRoleById($id);

			// Check if value posted is not empty and array valued
			if (is_array(Request::input('role_permission'))) {
				
				// Reset database column
				unset($role->permissions);

				//// remarks find a logic to mark admin to false {"admin":false} if not checked in form			
				$request = Request::input('role_permission');

				if(Request::has('role_permission.admin') == false) {

					$request['admin'] = false;

				} 
										
				ksort($request);

				// Set Role Permissions
				foreach ($request as $permission => $value) {

					$role->updatePermission($permission, ($value) ? true : false, true)->save();

				}	

			} else {

				// Set this to original model or sentinel would not update permissions
				//$role = Role::findOrFail($id);

				// Set permissions empty or admin with no value
				$role->permissions = ['admin'=>false];

				// Save role data
				$role->save();

			}

			// Saved checking
			$updated = true;

		} else {

			// Saved checking
			$updated = false;

		}

		if ($updated) {

			return response()->json(['status'=>'200','message'=>'Update Successfull!']);			

		} else {

			return response()->json(['status'=>'200','message'=>'Update Failed!']);

		}


	}

	/**
	 * Show the form for creating new role.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new role.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating role.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating role.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified role.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($role = $this->permissions->find($id))
		{
			$role->delete();

			return Redirect::to('permissions');
		}

		return Redirect::to('permissions');
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int     $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{

		$access = Input::get('access');

		if ($id && $access == 'role') {

			if ( ! $role = $this->permissions->findOrFail($id)) {
				
				return Redirect::to('admin.permissions.index');
				
			}

		} else if ($id && $access == 'user') {

			if ( ! $user = User::findOrFail($id)) {

				return Redirect::to('admin.permissions.index');

			}

	        // Change permissions data to array 
	        // $user->permissions = json_decode($user->permissions, true);

		}
		else {
			
			// Role data default
			$role = $this->permissions;

		}

		// Read ACL settings config for any permission access
    	$acl = config('setting.acl');
	               	      
		return $this->view('admin.sentinel.permissions.'.$access.'_form')->data(compact('mode','role','acl','user'))->title(ucfirst($access).' Permission');
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int     $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{
		$input = Input::all();

		$rules = [
			'name' => 'required',
			'slug' => 'required|unique:permissions'
		];

		if ($id)
		{
			$role = $this->permissions->find($id);

			$rules['slug'] .= ",slug,{$role->slug},slug";

			$messages = $this->validateRole($input, $rules);

			if ($messages->isEmpty())
			{
				$role->fill($input);

				$role->save();
			}
		}
		else
		{
			$messages = $this->validateRole($input, $rules);

			if ($messages->isEmpty())
			{
				$role = $this->permissions->create($input);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to('permissions');
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a role.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateRole($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
