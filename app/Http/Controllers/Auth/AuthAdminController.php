<?php namespace Tasks\Http\Controllers\Auth;

use Tasks\Http\Controllers\Controller;
//use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
//use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
//use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
//use Cartalyst\Sentinel\Activations;
use Sentinel;

// Load Laravel classes
use Input, View, Validator, Redirect;

class AuthAdminController extends Controller {

	//protected $auth = '';
	protected $setting = '';

	protected $admin_app = '';

	protected $admin_url = '';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Sentinel $auth)
	{

		$this->middleware('auth.admin', ['only' => 'getLogin','getLogout','getIndex']);

		//$this->auth = $auth;		

		//dd($auth::check());

		$this->setting 		= config('setting');

		$this->admin_app	= $this->setting['admin_app'];

		$this->admin_url	= $this->setting['admin_url'];

		
	}

	public function index() {

		if( ! Sentinel::check() ) {

			 return Redirect::to($this->admin_url.'/login');

		}

	}

	/**
	 * Show the form for logging the user in.
	 *
	 * @return \Illuminate\View\View
	 */
	public function login()
	{
		return View::make('admin.sentinel.login');
	}

	/**
	 * Handle posting of the form for logging the user in.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function processLogin()
	{
		try
		{
			$input = Input::all();

			$rules = [
				'email'    => 'required|email',
				'password' => 'required',
			];

			$validator = Validator::make($input, $rules);

			if ($validator->fails())
			{
				return Redirect::back()
					->withInput()
					->withErrors($validator);
			}

			$remember = (bool) Input::get('remember', false);

			if (Sentinel::authenticate(Input::all(), $remember))
			{
				return Redirect::intended($this->admin_url.'/dashboard');
			}

			$errors = 'Invalid login or password.';
		}
		catch (NotActivatedException $e)
		{
			$errors = 'Account is not activated!';

			return Redirect::to('reactivate')->with('user', $e->getUser());
		}
		catch (ThrottlingException $e)
		{
			$delay = $e->getDelay();

			$errors = "Your account is blocked for {$delay} second(s).";
		}

		return Redirect::back()
			->withInput()
			->withErrors($errors);
	}

	/**
	 * Show the form for the user registration.
	 *
	 * @return \Illuminate\View\View
	 */
	public function register()
	{
		return View::make('admin.sentinel.register');
	}

	/**
	 * Handle posting of the form for the user registration.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function processRegistration()
	{
		$input = Input::all();

		$rules = [
			'email'            => 'required|email|unique:users',
			'password'         => 'required',
			'password_confirm' => 'required|same:password',
		];

		$validator = Validator::make($input, $rules);

		if ($validator->fails())
		{
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		if ($user = Sentinel::register($input))
		{
			$activation = Activation::create($user);

			$code = $activation->code;

			$sent = Mail::send('admin.sentinel.emails.activate', compact('user', 'code'), function($m) use ($user)
			{
				$m->to($user->email)->subject('Activate Your Account');
			});

			if ($sent === 0)
			{
				return Redirect::to('register')
					->withErrors('Failed to send activation email.');
			}

			return Redirect::to('login')
				->withSuccess('Your accout was successfully created. You might login now.')
				->with('userId', $user->getUserId());
		}

		return Redirect::to('register')
			->withInput()
			->withErrors('Failed to register.');
	}

	/**
	 * Show the login form after logout redirect response.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout() {

        // Sentinel Logout
        Sentinel::logout();

        // Redirect to Admin Panel
        return Redirect::to('apanel/login');

	}

}
