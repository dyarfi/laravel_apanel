<?php namespace App\Http\Controllers;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
// Load Laravel class
use Request, Input, Validator, Redirect, Session;
// Load main models
use App\Db\Task;

class TasksController extends BasePublic {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Set return data 
	   	$tasks = Task::paginate(2);

	   	// Set pagination path
	   	$tasks->setPath('tasks');

	   	// Set data to return
	   	$data = ['tasks'=>$tasks];

	   	// Return data and view
	   	return $this->view('tasks.index')->data($data)->title('Tasks - Laravel Tasks'); 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Return view
		return $this->view('tasks.create')->title('Create Tasks - Laravel Tasks');

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		
		// Default filename 
		$fileName = '';

	  	// Default checker
	  	$uploaded = 0;

	  	// getting all of the post data
		$catch= ['title'	=> $request->input('title'),
				 'description'	=> $request->input('description')];

		// setting up rules
		$rules = ['title' => 'required',
		          'description' => 'required']; 

		// doing the validation, passing post data, rules and the messages
  		$validator = Validator::make($catch, $rules);

		if ($validator->fails()) {
		    // send back to the page with the input data and errors
		    return Redirect::to('tasks/create')->withInput()->withErrors($validator);
		}
	  	else {

		    // checking file is valid.
		    if ($request->file('image') && $request->file('image')->isValid()) {
			      $destinationPath = public_path().'/uploads'; // upload path
			      $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
			      $fileName = rand(11111,99999).'.'.$extension; // renaming image
			      $request->file('image')->move($destinationPath, $fileName); // uploading file to given path
			      $uploaded = 1;
			      // sending back with message
			      // Session::flash('success', 'Upload successfully'); 
			      // return Redirect::to('tasks/create');
		    } else {
			      // sending back with error message.
			      Session::flash('error', 'uploaded file is not valid');
			      return Redirect::to('tasks/create');
		    }

		}
			
		// Get all request
		$result = $request->all();	

		// Slip image file
		$result = is_array($result['image']) ? array_set($result, 'image', '') : array_set($result, 'image', $fileName);

    	// Set to database if image is uploaded
    	Task::create($result);			

    	// Set session flash to user
	    Session::flash('flash_message', 'Task successfully added!');

	    return redirect()->back();
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
        $task = Task::findOrFail($id);

		// Set data to return
	   	$data = ['task'=>$task];

	   	// Return data and view
	   	return $this->view('tasks.show')->data($data)->title('View Tasks - Laravel Tasks'); 

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$task = Task::findOrFail($id);

	    return view('tasks.edit')->withTask($task);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		// Get requested tasks
	    $task = Task::findOrFail($id);

		// Default filename 
		$fileName = '';

	  	// Default checker
	  	$uploaded = 0;

	  	// getting all of the post data
		$catch = ['title'	=> $request->input('title'),
				 'description'	=> $request->input('description')];

		// setting up rules
		$rules = ['title' => 'required',
		          'description' => 'required']; 

		// doing the validation, passing post data, rules and the messages
  		$validator = Validator::make($catch, $rules);

  		//dd ($validator);

		if ($validator->fails()) {

		    // send back to the page with the input data and errors
  		    return Redirect::to('tasks/'.$id.'/edit')->withInput()->withErrors($validator);
		}
	  	else {

		    // checking file is valid.
		    if ($request->file('image') && $request->file('image')->isValid()) {
			      $destinationPath = public_path().'/uploads'; // upload path
			      $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
			      $fileName = rand(11111,99999).'.'.$extension; // renaming image
			      $request->file('image')->move($destinationPath, $fileName); // uploading file to given path
			      $uploaded = 1;
			      // sending back with message
			      //Session::flash('success', 'Upload successfully'); 

			      //return Redirect::to('tasks/create');
		    }
		    else {
			      // sending back with error message.
			      // Session::flash('error', 'uploaded file is not valid');
			      // return Redirect::to('tasks/'.$id.'/edit');
		    	  $fileName = old('image');
		    }

		}

		// Get all request
		$result = $request->all();	
		
		// Slip image file
		$result = array_set($result, 'image', $fileName);

	    $task->fill($result)->save();

	    Session::flash('flash_message', 'Task successfully update!');


	    return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	    $task = Task::findOrFail($id);

	    $task->delete();

	    Session::flash('flash_message', 'Task successfully deleted!');

	    return redirect()->route('tasks.index');
	}

}
