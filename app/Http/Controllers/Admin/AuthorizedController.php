<?php namespace Tasks\Http\Controllers\Admin;

// Load Laravel classes and Sentinel classes
use Request, Redirect, Response, View, Route;
use Sentinel, Artisan, Session;
// User for debugging
use Event;

class AuthorizedController extends BaseAdmin {

	// Get user data via sentinel auth
	public $user = '';

	// Constructor
	public function __construct()
	{
		parent::__construct();

		/*
        if(! Sentinel::check()) {

    		return View::make('admin.errors.noaccess');

        } 
        */

		$this->user = Sentinel::getUser();

		//dd ( $this->user->roles() );
		//dd ($this->user->roles()->first()->permissions);

	}

	/**
	 * Holds the Page for Unauthorized access.
	 *
	 * @var \Http\Controllers\Admin\AuthorizedController
	 * @return view
	 */
	public function unauthorized () {

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

				$credentials = [
				    'email'    => Request::input('email'),
				    'password' => Request::input('password'),
				];

				$user = Sentinel::create($credentials);

			} else {

				// Set message
				$message = $user .' Already Existed!';
			}

			if ($user) {

				// Set message
				$message = $user->email .' Created!';
			}

			if (Request::input('migrate') == 1) {

				$exitCode = Artisan::call('migrate');

			}


		}

		//$message = ($exitCode == 0) ? '' : $exitCode . 'Migrate Successfully!';
		
		//dd ($message);
		//redirect()->with('success', $message);

		// Flash a key / value pair to the session
 		Session::flash('success', $message);

		// Return no access view
		return View::make('admin.sentinel.account.first_time');

	}


}
