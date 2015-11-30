<?php namespace Tasks\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Auth, Session, Redirect, Input, Validator, View;
// Load other classes
use Tasks\Http\Controllers\Admin\BaseAdmin;
// Load main models
use Tasks\Db\setting, Tasks\Db\User;

class SettingsController extends AuthorizedController {
	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $settings;

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
		$this->middleware('auth.admin');

		// Load settings and get repository data from database
		$this->settings = new Setting;

	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data 
	   	$settings = Input::get('path') === 'trashed' ? $this->settings->onlyTrashed()->paginate(4) : $this->settings->paginate(4);

	   	// Get deleted count
		$deleted = $this->settings->onlyTrashed()->get()->count();
	   	
	   	// Set data to return
	   	$data = ['settings'=>$settings,'deleted'=>$deleted,'junked'=>Input::get('path')];
		
		// Return data and view
	   	return $this->view('admin.sentinel.settings.index')->data($data)->title('Setting List'); 
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
        $setting = $this->settings->find($id);
        	       
		// Set data to return
	   	$data = ['setting'=>$setting];

	   	// Return data and view
	   	return $this->view('admin.sentinel.settings.show')->data($data)->title('View Setting - Laravel Tasks'); 

	}

	/**
	 * Show the form for creating new setting.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new setting.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating setting.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{	
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}
	
	/**
	 * Remove the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($setting = $this->settings->find($id))
		{
			// Add deleted_at and not completely delete
			$setting->delete();

			// Redirect with messages
			return Redirect::to(route('admin.settings.index'))->with('success', 'Setting Trashed!');
		}

		return Redirect::to(route('admin.settings.index'))->with('error', 'Setting Not Found!');
	}

	/**
	 * Restored the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($setting = $this->settings->onlyTrashed()->find($id))
		{
			
			// Restored back from deleted_at database
			$setting->restore();
			
			// Redirect with messages
			return Redirect::to(route('admin.settings.index'))->with('success', 'Setting Restored!');
		}

		return Redirect::to(route('admin.settings.index'))->with('error', 'Setting Not Found!');;
	}

	/**
	 * Delete the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($setting = $this->settings->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$setting->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.settings.index'))->with('success', 'Setting Permanently Deleted!');
		}

		return Redirect::to(route('admin.settings.index'))->with('error', 'Setting Not Found!');
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
			if ( ! $setting = $this->settings->find($id))
			{
				return Redirect::to(route('admin.settings.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$setting = $this->settings;
		}

		return $this->view('admin.sentinel.settings.form')->data(compact('mode', 'setting'))->title('Setting '.$mode);
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
		//$input['slug'] = isset($input['name']) ? snake_case($input['name']) : '';

		$rules = [
			'name' 		   => 'required',
			'description'  => 'required',
			'value'  	   => 'required',
			'status'	   => 'boolean'
		];

		if ($id)
		{
			$setting = $this->settings->find($id);

			$messages = $this->validateSetting($input, $rules);

			if ($messages->isEmpty())
			{
				$setting->update($input);
			}
		}
		else
		{
			$messages = $this->validateSetting($input, $rules);

			if ($messages->isEmpty())
			{
				$setting = $this->settings->create($input);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.settings.index'))->with('success', 'Setting Updated!');
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a setting.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateSetting($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
