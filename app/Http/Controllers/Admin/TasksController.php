<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Auth, Session, Redirect, Input, Validator, View;
// Load other classes
use App\Http\Controllers\Admin\BaseAdmin;
// Load main models
use App\Db\Task, App\Db\User;

class TasksController extends BaseAdmin {
	/**
	 * Holds the Sentinel Users repository.
	 *
	 * @var \Cartalyst\Sentinel\Users\EloquentUser
	 */
	protected $tasks;

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

		// Load tasks and get repository data from database
		$this->tasks = new Task;
		
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		// Set return data 
	   	$tasks = Input::get('path') === 'trashed' ? $this->tasks->onlyTrashed()->get() : $this->tasks->get();

	   	// Get deleted count
		$deleted = $this->tasks->onlyTrashed()->get()->count();		   
		
	   	// Set data to return
	   	$data = ['tasks' => $tasks,'deleted' => $deleted,'junked' => Input::get('path')];

	   	// Load needed scripts
	   	$scripts = [
	   				'dataTables'=> 'assets.admin/js/jquery.dataTables.min.js',
	   				'dataTableBootstrap'=> 'assets.admin/js/jquery.dataTables.bootstrap.min.js',
	   				'dataTableTools'=> 'assets.admin/js/dataTables.tableTools.min.js',
	   				'dataTablesColVis'=> 'assets.admin/js/dataTables.colVis.min.js'
	   				];
	   	
		// Return data and view
	   	return $this->view('admin.sentinel.tasks.index')->data($data)->scripts($scripts)->title('Task List'); 
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
        $task = $this->tasks->find($id);
        	       
		// Set data to return
	   	$data = ['task'=>$task];

	   	// Return data and view
	   	return $this->view('admin.sentinel.tasks.show')->data($data)->title('View Task'); 

	}

	/**
	 * Show the form for creating new task.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new task.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating task.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{	
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating task.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}
	
	/**
	 * Remove the specified task.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($task = $this->tasks->find($id))
		{
			// Add deleted_at and not completely delete
			$task->delete();

			// Redirect with messages
			return Redirect::to(route('admin.tasks.index'))->with('success', 'Task Trashed!');
		}

		return Redirect::to(route('admin.tasks.index'))->with('error', 'Task Not Found!');
	}

	/**
	 * Restored the specified task.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($task = $this->tasks->onlyTrashed()->find($id))
		{
			
			// Restored back from deleted_at database
			$task->restore();
			
			// Redirect with messages
			return Redirect::to(route('admin.tasks.index'))->with('success', 'Task Restored!');
		}

		return Redirect::to(route('admin.tasks.index'))->with('error', 'Task Not Found!');;
	}

	/**
	 * Delete the specified task.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($task = $this->tasks->onlyTrashed()->find($id))
		{

			// Completely delete from database
			$task->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.tasks.index'))->with('success', 'Task Permanently Deleted!');
		}

		return Redirect::to(route('admin.tasks.index'))->with('error', 'Task Not Found!');
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
			if ( ! $task = $this->tasks->find($id))
			{
				return Redirect::to(route('admin.tasks.index'))->withErrors('Not found data!');;
			}
		}
		else
		{
			$task = $this->tasks;
		}

		return $this->view('admin.sentinel.tasks.form')->data(compact('mode', 'task'))->title('Task '.$mode);
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
			$task = $this->tasks->find($id);

			$messages = $this->validateTask($input, $rules);

			if ($messages->isEmpty())
			{
				$task->update($input);
			}

		}
		else
		{
			$messages = $this->validateTask($input, $rules);

			if ($messages->isEmpty())
			{
				$task = $this->tasks->create($input);
			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.tasks.index'))->with('success', 'Task Updated!');
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a task.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateTask($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}


}
