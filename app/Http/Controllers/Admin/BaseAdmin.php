<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes and Sentinel classes
use Request, Redirect, Response, View, Route;
use Sentinel, Artisan, Session;
// User for debugging
use Event;

class BaseAdmin extends ThemeAdmin {

	// Get current class basename
	public $class_name = '';

	// get current action basename
	public $action_name = '';

	// Get user data via sentinel auth
	public $user = '';

	// Constructor
	public function __construct()
	{
		parent::__construct();
		
		$this->user = Sentinel::getUser();

	}


	public function index() {

		return $this->unauthorize();

	}

	/**
	 * Holds the Page for Unauthorized access.
	 *
	 * @var \Http\Controllers\Admin\AuthorizedController
	 * @return view
	 */
	public function unauthorize () {

		// Check if the sentinel login os still existed
		if ( Sentinel::check() ) {

			// Check if ajax requested
			if ( Request::ajax()) {

				return Response::json([ 'error' => 403 , 'message' => 'Unauthorized action.' ], 403);

				// return redirect()->back()->withInput()->withErrors('Unauthorized access!');
				// return abort(403);
				// return abort(403, 'Unauthorized action.');
				// return Redirect::back()->withInput()->withErrors('Unauthorized access!');
				
			}			

			// Return no access view
			return View::make('admin.errors.noaccess');

		} else {

			// Return redirect back to login page if not logged by sentinel
			return Redirect::to(route('admin.login'))->withErrors('Unauthorized access!');

		}
		
	}
    

    /**
    * First time setup for developers only
    * @var should be HTTP Basic Authenticate
    * @return view
    */
	public function setup() {

		// Default variable setup
		$exitCode = ''; 
		$message = '';
		$user = '';

		// Check post parameters
		if (Request::has('email') && Request::has('password')) {

			// Check first by email on database
			$user_check = Sentinel::findByCredentials(['login' => Request::input('email')]);

			// Check user
			if (!$user_check) {
				

				$set_acl = [];

				foreach (config('setting.acl') as $acl) {
					if (isset($acl['Admin'])) {
						$set_acl = array_flatten($acl['Admin']);
					}	
				}

				$set_acl = array_fill_keys($set_acl,true);

				$is_admin = Request::input('is_admin') == 1 ? $set_acl : [];
				
				$credentials = [
				    'email'    => Request::input('email'),
				    'password' => Request::input('password'),
				    'permissions' => $is_admin,
				];

				$user = Sentinel::create($credentials);

				if ($is_admin) {

					$role = Sentinel::findRoleByName('Admin');

					if (!$role) {

						$role = Sentinel::getRoleRepository()->createModel()->create([
						    'name' => 'Admin',
						    'slug' => 'admin',
						    'permissions' => ['admin' => true]
						]);
					}

					$role->users()->attach($user);

				}

			} else {

				// Set message
				$message = $user .' Already Existed!';
			}

			if ($user) {

				// Set message
				$message = $user->email .' Created!';
			}

			if (Request::input('migrate') == 1) {

				// Call php artisan command
				$exitCode = Artisan::call('migrate');

			}


		}

		//$message = ($exitCode == 0) ? '' : $exitCode . 'Migrate Successfully!';

		if ($message) {
			// Flash a key / value pair to the session
	 		//Session::flash('success', $message .' '. $exitCode > 0 ? '- '. $exitCode .' migration' : 'But no migration');
	 		Session::flash('success', $message);		
		}
 		// Forget the message
 		//Session::forget('success');

 		 // Set layout template
 		$this->layout = 'admin.template_login';

		// Return no access view
		return $this->view('admin.sentinel.account.first_time')->title('First Setup and Migrate!');

	}


}
