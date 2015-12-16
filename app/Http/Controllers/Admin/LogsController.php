<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View;
// Load Sentinel and Socialite classes
use Sentinel, Socialite;
// Load other classes
use App\Http\Controllers\Admin\BaseAdmin;
// Load main models
use App\Db\Role;

class LogsController extends AuthorizedController {

	/**
	 * Holds the Sentinel Roles repository.
	 *
	 * @var \Cartalyst\Sentinel\Roles\EloquentRole
	 */
	protected $roles;

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

		// Load roles and create model from Sentinel
		$this->roles = Sentinel::getRoleRepository()->createModel();
		
	}

	/**
	 * Display a listing of roles.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		// Set return data 
	   	$roles = Input::get('path') === 'trashed' ? Role::onlyTrashed()->paginate(4) : Role::paginate(4);

	   	// Get deleted count
		$deleted = Role::onlyTrashed()->get()->count();

		// Get trashed mode
		$junked  = Input::get('path');

		return $this->view('admin.sentinel.logs.index')->data(compact('roles','deleted','junked'))->title('Logs Listing');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Get data from database
        $role = $this->roles->findOrFail($id);
        
        // Read ACL settings config for any permission access
        $acl = config('setting.acl');
	               	      
		// Set data to return
	   	$data = ['role'=>$role,'acl'=>$acl];

	   	// Return data and view
	   	return $this->view('admin.sentinel.roles.show')->data($data)->title('View Role'); 

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
	public function trash($id)
	{
		if ($role = Role::find($id))
		{

			// Add deleted_at and not completely delete
			$role->delete();

			// Redirect with messages
			return Redirect::to(route('admin.roles.index'))->with('success', 'Role Trashed!');
		}

		return Redirect::to(route('admin.roles.index'))->with('error', 'Role Not Found!');;
	}

	/**
	 * Restored the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($role = Role::onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$role->restore();

			// Redirect with messages
			return Redirect::to(route('admin.roles.index'))->with('success', 'Role Restored!');
		}

		return Redirect::to(route('admin.roles.index'))->with('error', 'Role Not Found!');
	}

	/**
	 * Remove the specified role.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($role = Role::onlyTrashed()->find($id))
		{

			// Completely delete from database
			$role->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.roles.index'))->with('success', 'Role Permanently Deleted!');

		}

		return Redirect::to(route('admin.roles.index'))->with('error', 'Role Not Found!');;
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
		if ($id)
		{
			if ( ! $role = $this->roles->find($id))
			{
				return Redirect::to(route('admin.roles.index'));
			}
		}
		else
		{
			$role = $this->roles;
		}

		
		$role_access = config('setting.acl');
		
		$role = Sentinel::findRoleById($this->user->roles()->first()->id);

		//dd (array_keys($role_access));

		// dd ($role->hasAccess('tasks'));
		
		return $this->view('admin.sentinel.roles.form')->data(compact('mode', 'role'))->title('Roles '.$mode);
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

		//dd ($input);

		if ($input['permissions'] === 'true') {

			$input['permissions'] = ['admin'=>true];

		} else {

			$input['permissions'] = ['admin'=>false];

		}

		$rules = [
			'name' => 'required',
			'slug' => 'required|unique:roles'
		];
		
		if ($id)
		{

			$role = $this->roles->find($id);

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

				$role = $this->roles->create($input);				

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.roles.index'))->with('success', 'Role Updated!');;
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
