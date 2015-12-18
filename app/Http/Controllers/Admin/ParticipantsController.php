<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Session, Redirect, Sentinel, Activation, Socialite, Input, Validator, View;
// Load main models
use App\Db\Role, App\Db\User;

class ParticipantsController extends AuthorizedController {

	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $users;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
		// Parent constructor
		parent::__construct();
		
		// Load Http/Middleware/Admin controller
		$this->middleware('auth.admin',['except'=>'profile']);

		// Load users and get repository data from Sentinel
		$this->users = new User;

		$this->roles = new Role;

	}

	/**
	 * Display a listing of users.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

	   	//dd ($this->users->find(1)->roles);

		// Set return data 
	   	$users = Input::get('path') === 'trashed' ? $this->users->onlyTrashed()->paginate(4) : $this->users->paginate(4);

	   	// Get deleted count
		$deleted = $this->users->onlyTrashed()->get()->count();
	   	
	   	// Set data to return
	   	$data = ['users'=>$users,'deleted'=>$deleted,'junked'=>Input::get('path')];

	   	return $this->view('admin.sentinel.users.index')->data($data)->title('User List');
	}	
	
	/**
	 * Display user profile of the resource.
	 *
	 * @return Response
	 */
	public function profile() {

		// Set return data 
	   	//$user = Sentinel::getUser();
	   	$user = $this->user;	
	   	//dd($user);

	   	// Set data to return
	   	$data = ['user'=>$user];

	   	// Return data and view
	   	return $this->view('admin.sentinel.users.profile')->data($data)->title('User Profile - Laravel Users'); 
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
        $user = $this->users->findOrFail($id);

        // Change permissions data to array 
        $user->permissions = json_decode($user->permissions, true);

        // Read ACL settings config for any permission access
        $acl = config('setting.acl');
        	               	       
		// Set data to return
	   	$data = ['user'=>$user,'acl'=>$acl];

	   	// Return data and view
	   	return $this->view('admin.sentinel.users.show')->data($data)->title('View User - Laravel Tasks'); 

	}

	/**
	 * Show the form for creating new user.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new user.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating user.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{	
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($user = $this->users->find($id))
		{
			
			// Add deleted_at and not completely delete
			$user->delete();
			
			// Redirect with messages
			return Redirect::to(route('admin.users.index'))->with('success', 'User Trashed!');
		}

		return Redirect::to(route('admin.users.index'))->with('error', 'User Not Found!');
	}

	/**
	 * Restored the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($user = $this->users->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$user->restore();

			// Redirect with messages
			return Redirect::to(route('admin.users.index'))->with('success', 'User Restored!');
		}

		return Redirect::to(route('admin.users.index'))->with('error', 'User Not Found!');
	}
	/**
	 * Remove the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get user from id fetch
		if ($user = $this->users->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->users->onlyTrashed()->find($id)->roles()->detach();

			// Permanently delete
			$user->forceDelete();

			return Redirect::to(route('admin.users.index'))->with('success', 'User Permanently Deleted!');
		}

		return Redirect::to(route('admin.users.index'))->with('error', 'User Not Found!');
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
			if ( ! $user = $this->users->find($id))
			{
				return Redirect::to(route('admin.users'));
			}
		}
		else
		{
			$user = Sentinel::getUserRepository()->createModel();
		}

		$roles = $this->roles->lists('name', 'id');

		return $this->view('admin.sentinel.users.form')->data(compact('mode', 'user', 'roles'))->title('User '.$mode);
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
		$input = array_filter(Input::all());

		$rules = [
			'first_name' => 'required',
			'last_name'  => 'required',
			'role_id'  	 => 'required',			
			'email'      => 'required|unique:users'
		];
		
		if ($id)
		{
			$user = Sentinel::getUserRepository()->createModel()->find($id);

			$rules['email'] .= ",email,{$user->email},email";

			$messages = $this->validateUser($input, $rules);

			if ($messages->isEmpty())
			{

				if ( ! $user->roles()->first() ) {
					
					// Syncing relationship Many To Many // Create New
					$user->roles()->sync(['role_id'=>$input['role_id']]);
					
				} else {

					// Syncing relationship Many To Many // Update Existing
					$user->roles()->sync(['role_id'=>$input['role_id']]);
					
					// Update user model data
					Sentinel::getUserRepository()->update($user, $input);

				}
				
			}
		}
		else
		{
			
			$messages = $this->validateUser($input, $rules);

			if ($messages->isEmpty())
			{
				// Create user into the database
				$user = Sentinel::getUserRepository()->create($input);
				
				// Syncing relationship Many To Many // Create New
				$user->roles()->sync(['role_id'=>$input['role_id']]);

				$code = Activation::create($user);

				Activation::complete($user, $code);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.users.index'))->with('success', 'User Updated!');;
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a user.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateUser($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

	/**
	 * Show the dashboard for current users
	 *
	 * @param  null  
	 * @return Response
	 */
	public function dashboard() {

		// Set return data 
	   	$user = $this->user;

	   	//dd($user);
	   	
	   	// Set data to return
	   	$data = ['user'=>$user];

	   	// Return data and view
	   	return $this->view('admin.sentinel.users.dashboard')->data($data)->title('User Profile - Laravel Users'); 
	}

}