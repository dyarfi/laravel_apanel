<?php namespace Tasks\Http\Controllers\Admin;

// Load Laravel classes and Sentinel classes
use Request, Redirect, Response, View, Route;
use Sentinel;
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

}
