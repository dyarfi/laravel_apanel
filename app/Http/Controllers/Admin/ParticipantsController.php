<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Session, Redirect, Sentinel, Activation, Socialite, Input, Validator, View;
// Load main models
use App\Db\Role, App\Db\Participant;

class ParticipantsController extends BaseAdmin {

	/**
	 * Holds the Sentinel Participants repository.
	 *
	 * @var \Cartalyst\Sentinel\Participants\EloquentParticipant
	 */
	public $participants;

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

		// Load participants and get repository data from Sentinel
		$this->participants = new Participant;

		//$this->roles = new Role;

	}

	/**
	 * Display a listing of participants.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

	   	//dd ($this->participants->find(1)->roles);
		
		// Set return data 
	   	$participants = Input::get('path') === 'trashed' ? $this->participants->onlyTrashed()->paginate(4) : $this->participants->paginate(4);

	   	// Get deleted count
		$deleted = $this->participants->onlyTrashed()->get()->count();
	   	
	   	// Set data to return
	   	$data = ['participants'=>$participants,'deleted'=>$deleted,'junked'=>Input::get('path')];

  		// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'assets.admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'assets.admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'assets.admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'assets.admin/js/dataTables.colVis.min.js'
	   				];

	   	return $this->view('admin.sentinel.participants.index')->data($data)->scripts($scripts)->title('Participants List');
	}	
	
	/**
	 * Display participant profile of the resource.
	 *
	 * @return Response
	 */
	public function profile() {

		// Set return data 
	   	//$participant = Sentinel::getParticipant();
	   	//$participant = $this->participant;	
	   	//dd($participant);

	   	// Set data to return
	   	$data = ['participant'=>$participant];

	   	// Return data and view
	   	return $this->view('admin.sentinel.participants.profile')->data($data)->title('Participant Profile'); 
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
        $participant = $this->participants->findOrFail($id);

		// Set data to return
	   	$data = ['participant'=>$participant,'acl'=>$acl];

	   	// Return data and view
	   	return $this->view('admin.sentinel.participants.show')->data($data)->title('View Participant'); 

	}

	/**
	 * Show the form for creating new participant.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new participant.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating participant.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{	
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating participant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified participant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($participant = $this->participants->find($id))
		{
			
			// Add deleted_at and not completely delete
			$participant->delete();
			
			// Redirect with messages
			return Redirect::to(route('admin.participants.index'))->with('success', 'Participant Trashed!');
		}

		return Redirect::to(route('admin.participants.index'))->with('error', 'Participant Not Found!');
	}

	/**
	 * Restored the specified participant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($participant = $this->participants->onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$participant->restore();

			// Redirect with messages
			return Redirect::to(route('admin.participants.index'))->with('success', 'Participant Restored!');
		}

		return Redirect::to(route('admin.participants.index'))->with('error', 'Participant Not Found!');
	}
	/**
	 * Remove the specified participant.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{

		// Get participant from id fetch
		if ($participant = $this->participants->onlyTrashed()->find($id))
		{

			// Delete from pivot table many to many
			$this->participants->onlyTrashed()->find($id)->roles()->detach();

			// Permanently delete
			$participant->forceDelete();

			return Redirect::to(route('admin.participants.index'))->with('success', 'Participant Permanently Deleted!');
		}

		return Redirect::to(route('admin.participants.index'))->with('error', 'Participant Not Found!');
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
			if ( ! $participant = $this->participants->find($id))
			{
				return Redirect::to(route('admin.participants'));
			}
		}
		else
		{
			$participant = $this->participants;
		}
		
		return $this->view('admin.sentinel.participants.form')->data(compact('mode', 'participant'))->title('Participant '.$mode);
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
			'email'      => 'required|unique:participants'
		];
		
		if ($id)
		{
			$participant = Sentinel::getParticipantRepository()->createModel()->find($id);

			$rules['email'] .= ",email,{$participant->email},email";

			$messages = $this->validateParticipant($input, $rules);

			if ($messages->isEmpty())
			{

				if ( ! $participant->roles()->first() ) {
					
					// Syncing relationship Many To Many // Create New
					$participant->roles()->sync(['role_id'=>$input['role_id']]);
					
				} else {

					// Syncing relationship Many To Many // Update Existing
					$participant->roles()->sync(['role_id'=>$input['role_id']]);
					
					// Update participant model data
					Sentinel::getParticipantRepository()->update($participant, $input);

				}
				
			}
		}
		else
		{
			
			$messages = $this->validateParticipant($input, $rules);

			if ($messages->isEmpty())
			{
				// Create participant into the database
				$participant = Sentinel::getParticipantRepository()->create($input);
				
				// Syncing relationship Many To Many // Create New
				$participant->roles()->sync(['role_id'=>$input['role_id']]);

				$code = Activation::create($participant);

				Activation::complete($participant, $code);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.participants.index'))->with('success', 'Participant Updated!');;
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a participant.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateParticipant($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

	/**
	 * Show the dashboard for current participants
	 *
	 * @param  null  
	 * @return Response
	 */
	public function dashboard() {

		// Set return data 
	   	$participant = $this->participant;

	   	//dd($participant);
	   	
	   	// Set data to return
	   	$data = ['participant'=>$participant];

	   	// Return data and view
	   	return $this->view('admin.sentinel.participants.dashboard')->data($data)->title('Participant Dashboard'); 
	}

}
