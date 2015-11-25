<?php namespace Tasks\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Session, Redirect, Sentinel, Activation, Socialite, Input, Validator, View;
// Load main models
use Tasks\Db\Role, Tasks\Db\User;

class UsersController extends AuthorizedController {

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
		$this->users = Sentinel::getUserRepository();

		$this->roles = Sentinel::getRoleRepository();

	}

	/**
	 * Display a listing of users.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		//dd ($this->user);

		// Load users data
		$users = $this->user->paginate(4);

		return View::make('admin.sentinel.users.index', compact('users'));
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
        $user = User::findOrFail($id);

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
	public function delete($id)
	{
		if ($user = $this->users->createModel()->find($id))
		{
			$user->delete();

			return Redirect::to('users');
		}

		return Redirect::to('users');
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
			if ( ! $user = $this->users->createModel()->find($id))
			{
				return Redirect::to(route('admin.users'));
			}
		}
		else
		{
			$user = $this->users->createModel();
		}

		$roles = Role::lists('name', 'id');

		return View::make('admin.sentinel.users.form', compact('mode', 'user', 'roles'));
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
			//'email'      => 'required|unique:users'
		];
		
		if ($id)
		{
			$user = $this->users->createModel()->find($id);

			//$rules['email'] .= ",email,{$user->email},email";

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
					$this->users->update($user, $input);

				}
				
			}
		}
		else
		{
			$messages = $this->validateUser($input, $rules);

			if ($messages->isEmpty())
			{
				// Create user into the database
				$user = $this->users->create($input);
				
				// Syncing relationship Many To Many // Create New
				$user->roles()->sync(['role_id'=>$input['role_id']]);

				$code = Activation::create($user);

				Activation::complete($user, $code);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.users'))->with('success', 'User Updated!');;
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
