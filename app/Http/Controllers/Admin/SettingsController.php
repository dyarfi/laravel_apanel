<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Auth, Session, Redirect, Input, Validator, View;
// Load other classes
use App\Http\Controllers\Admin\BaseAdmin;
// Load main models
use App\Db\Setting, App\Db\User;

class SettingsController extends BaseAdmin {
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

		
		//$subject = 'The Truth newsletter - Laravel Newsletter';
		//$contents = '<h1>Big news</h1>The world is carried by four elephants on a turtle!';

		//dd(Newsletter::createCampaign($subject, $contents));


		//Newsletter::subscribe('defrian.yarfi@gmail.com', ['firstName'=>'Havelock', 'lastName'=>'Vetinari'], 'Laravel Newsletter Page');
		//Newsletter::subscribe('dyarfi20@gmail.com', ['firstName'=>'Havelock2', 'lastName'=>'Vetinari2'], 'Laravel Newsletter Page');
		
		//Newsletter::unsubscribe('sam.vimes@discworld.com', ['firstName'=>'Sam', 'lastName'=>'Vines'], 'mySecondList');

		//dd(Newsletter::createCampaign($subject, $contents, 'Laravel Newsletter Page'));

		//dd(Newsletter::sendCampaign('565089'));

		//$api = Newsletter::getApi();

		//dd($api->call('campaigns/list',1));

		//$lists = Newsletter::getApi();		
		//$campaigns = element('data',$lists);

		//dd($lists->call('campaigns/list',true));

	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		//print_r($this->settings->setToConfig());
		//exit;
		//Config::set('setting.configure', $this->settings->setToConfig());
		//print_r(Config::get('setting.configure'));
		//exit;

		//$arrays = array_dot($settings);

		//foreach ($this->settings->setToConfig() as $key => $val) {
			//print_r($key);
			//$asdf = $array['group'];
			//print_r($val['group']);
		//}

		// Set return data 
	   	$settings = Input::get('path') === 'trashed' ? $this->settings->onlyTrashed()->orderBy('name')->get() : $this->settings->orderBy('name')->get();

	   	// Get deleted count
		$deleted = $this->settings->onlyTrashed()->get()->count();		   
		
	   	// Set data to return
	   	$data = ['settings' => $settings,'deleted' => $deleted,'junked' => Input::get('path'), 'config_settings' => $this->settings->setToConfig()];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'assets.admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'assets.admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'assets.admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'assets.admin/js/dataTables.colVis.min.js',
	   				'typehead.jquery'=> 'assets.assets/js/typeahead.jquery.min.js'
	   				];
	   	
		// Return data and view
	   	return $this->view('admin.sentinel.settings.index')->data($data)->scripts($scripts)->title('Setting List'); 
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
	   	return $this->view('admin.sentinel.settings.show')->data($data)->title('View Setting'); 

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

	   	// Load needed scripts
	   	$scripts = ['typehead.jquery'=> 'assets.admin/js/typeahead.jquery.min.js'];

		return $this->view('admin.sentinel.settings.form')->data(compact('mode', 'setting'))->scripts($scripts)->title('Setting '.$mode);
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
			'slug' 		   => 'required',
			'description'  => 'required',
			'value'  	   => 'required',
			'status'	   => 'boolean'
		];

		if ($id)
		{
			
			//print_r($input);
			//exit;

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

	/**
	 * Change site setting.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return boolean
	 */
	public function change($id=null) {
		
		// Default all input variables
		$input = Input::all();

		// Default variable checking
		$updated = false;	    

		// Session checking variable
		$session = base64_decode(Request::input('setting_form')) == Session::getId();

		// POST Request Method Checking
		if (Request::server('REQUEST_METHOD') === 'POST') {

		    // Check if requested contain 'access_permission'
			if (Request::has('setting_form') && $session) {
				
				// $setting = Setting::where('slug', 'site-theme')->update(['value'=>'bluesky']);
				print_r($input['email-contact']);
				exit;

				foreach ($input as $value) {

					//print_r(Setting::slug($input)->get());

				}

				exit;		

				// Saved checking
				$updated = true;

			} else {

				// Saved checking
				$updated = false;

			}

		} else {
			
			// Return response Unauthorized
			return response()->json(['status'=>'200','message'=>'Unauthorized!']);

		}


		if ($updated) {

			// Return response successfull
			return response()->json(['status'=>'200','message'=>'Update Successfull!']);			

		} else {

			// Return response failed
			return response()->json(['status'=>'200','message'=>'Update Failed!']);

		}


	}


}
