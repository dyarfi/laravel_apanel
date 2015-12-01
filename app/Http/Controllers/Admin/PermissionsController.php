<?php namespace Tasks\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Auth, Session, Redirect, Input, View;
// Load Sentinel and Socialite classes
use Sentinel, Socialite;
// Load other classes
use Tasks\Http\Controllers\Admin\BaseAdmin;
// Load main models
use Tasks\Db\User, Tasks\Db\Role, Tasks\Db\Task;

class PermissionsController extends AuthorizedController {

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

		$this->permissions = Sentinel::getRoleRepository();
	}

	/**
	 * Display a listing of permissions.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		
		$permissions = Role::all();
		
		$permissions->each(function($value) {
			$value->permissions = json_decode($value->permissions,true);
			return $value;
		});

		return View::make('admin.sentinel.permissions.index', compact('permissions'));
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
				unset($user->permissions);

				// Save user data
				$user->save();

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

				// Set Role Permissions
				foreach (Request::input('role_permission') as $permission => $value) {
					$role->updatePermission($permission, ($value) ? true : false, true)->save();
				}

			} else {

				// Set empty permission
				unset($role->permissions);

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

		if ($id)
		{
			if ( ! $role = $this->permissions->findOrFail($id))
			{
				return Redirect::to('admin.permissions.index');
			}
		}
		else
		{
			$role = $this->permissions;
		}

		// Read ACL settings config for any permission access
    	$acl = config('setting.acl');
	               	      
		return $this->view('admin.sentinel.permissions.'.$access.'_form')->data(compact('mode','role','acl'))->title(ucfirst($access).' Permission');
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
