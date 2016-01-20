<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Auth, Session, Redirect, Input, Validator, View;
// Load other classes
use App\Http\Controllers\Admin\BaseAdmin;
// Load main models
use App\Db\Career, App\Db\User;

class CareersController extends BaseAdmin {
	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $careers;

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

		// Load careers and get repository data from database
		$this->careers = new Career;
		
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data 
	   	$careers = Input::get('path') === 'trashed' ? $this->careers->onlyTrashed()->get() : $this->careers->get();

	   	// Get deleted count
		$deleted = $this->careers->onlyTrashed()->get()->count();		   
		
	   	// Set data to return
	   	$data = ['careers' => $careers,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'assets.admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'assets.admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'assets.admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'assets.admin/js/dataTables.colVis.min.js'
	   				];
	   	
		// Return data and view
	   	return $this->view('admin.sentinel.careers.index')->data($data)->scripts($scripts)->title('Career List'); 
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
        $career = $this->careers->find($id);
        	       
		// Set data to return
	   	$data = ['career'=>$career];

	   	// Return data and view
	   	return $this->view('admin.sentinel.careers.show')->data($data)->title('View Career'); 

	}

	/**
	 * Show the form for creating new career.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new career.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating career.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{	
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating career.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}
	
	/**
	 * Remove the specified career.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($career = $this->careers->find($id))
		{
			// Add deleted_at and not completely delete
			$career->delete();

			// Redirect with messages
			return Redirect::to(route('admin.careers.index'))->with('success', 'Career Trashed!');
		}

		return Redirect::to(route('admin.careers.index'))->with('error', 'Career Not Found!');
	}

	/**
	 * Restored the specified career.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($career = $this->careers->onlyTrashed()->find($id))
		{
			
			// Restored back from deleted_at database
			$career->restore();
			
			// Redirect with messages
			return Redirect::to(route('admin.careers.index'))->with('success', 'Career Restored!');
		}

		return Redirect::to(route('admin.careers.index'))->with('error', 'Career Not Found!');;
	}

	/**
	 * Delete the specified career.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($career = $this->careers->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$career->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.careers.index'))->with('success', 'Career Permanently Deleted!');
		}

		return Redirect::to(route('admin.careers.index'))->with('error', 'Career Not Found!');
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
			if ( ! $career = $this->careers->find($id))
			{
				return Redirect::to(route('admin.careers.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$career = $this->careers;
		}

		return $this->view('admin.sentinel.careers.form')->data(compact('mode', 'career'))->title('Career '.$mode);
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
		//$request = new Request;

		$input = array_filter(Input::all());
		//$input = $request;
		//print_r($input);
		//exit;
		//$input['slug'] = isset($input['title']) ? snake_case($input['title']) : '';

		//$request = $input;		
		
		$rules = [
			'title' 	   => 'required',
			'slug' 		   => 'required',
			'description'  => 'required',
			//'value'  	   => 'required',
			'status'	   => 'boolean'
		];

		if ($id)
		{
			$career = $this->careers->find($id);

			$messages = $this->validateCareer($input, $rules);

			// checking file is valid.
		    //if ($request->file('image') && $request->file('image')->isValid()) {
			if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully'); 
		      //return Redirect::to(route('admin.careers.create'));
		    }
		    else {
			      // sending back with error message.
			      // Session::flash('error', 'uploaded file is not valid');
			      // return Redirect::to('careers/'.$id.'/edit');
		    	  $fileName = old('image') ? old('image') : $career->image;
		    }

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;	
				
				// Set user id
				$result['user_id'] = Auth::getUser()->id;

				// Slip image file
				$result = array_set($result, 'image', $fileName);

				$career->update($result);
				//$career->update($input);
			}

		}
		else
		{
			$messages = $this->validateCareer($input, $rules);
			// checking file is valid.
		    if (!empty($input['image']) && !$input['image']->getError()) {
		      $destinationPath = public_path().'/uploads'; // upload path
		      $extension = $input['image']->getClientOriginalExtension(); // getting image extension
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      $input['image']->move($destinationPath, $fileName); // uploading file to given path
		      // sending back with message
		      //Session::flash('success', 'Upload successfully'); 
		      //return Redirect::to(route('admin.careers.create'));
		    }
		    else {
		      // sending back with error message.
		      Session::flash('error', 'uploaded file is not valid');
		      return Redirect::to(route('admin.careers.create'));
		    }

			if ($messages->isEmpty())
			{
				// Get all request
				$result = $input;	

				// Set user id
				$result['user_id'] = Auth::getUser()->id;

				// Slip image file
				$result = is_array($result['image']) ? array_set($result, 'image', '') : array_set($result, 'image', $fileName);

				//$career = $this->careers->create($input);
				$career = $this->careers->create($result);
				
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.careers.index'))->with('success', 'Career Updated!');
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a career.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateCareer($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
