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

		$this->permissions = User::all();
	}

	/**
	 * Display a listing of permissions.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		
		$permissions = User::all();
		
		$permissions->each(function($value) {
			$value->permissions = json_decode($value->permissions,true);
			return $value;
		});

		return View::make('admin.sentinel.permissions.index', compact('permissions'));
	}


	public function change($id=null) {

		// Get user model
	    $user = User::find($id);
		
	    //dd(Request::input('access_permission'));

	    // Check if requested contain 'access_permission'
		if (Request::has('access_permission')) {

			// Get request input and convert to json
			$request = json_encode(Request::input('access_permission'));
			// Replace the string "true" into true
			$user->permissions = str_replace(':"true"',':true',$request);

		} else {

			$user->permissions = '';

		}
	
		// Save user data
		$user->save();

		return response()->json(['status'=>'200','message'=>'Update Successfull!']);

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
		if ($id)
		{
			if ( ! $role = $this->permissions->find($id))
			{
				return Redirect::to('permissions');
			}
		}
		else
		{
			$role = $this->permissions;
		}

		return View::make('admin.sentinel.permissions.form', compact('mode', 'role'));
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
