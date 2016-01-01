<?php namespace App\Http\Controllers\Admin;

// Load Laravel classes
use Route, Request, Session, Redirect, Input, Validator, View;
// Load other classes
use App\Http\Controllers\Admin\BaseAdmin;
// Load main models
use App\Db\Page;

class PagesController extends BaseAdmin {

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

		$this->pages = new Page;

	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	
		// Set return data 
	   	$pages = Input::get('path') === 'trashed' ? Page::onlyTrashed()->paginate(4) : Page::paginate(4);

	   	// Get deleted count
		$deleted = Page::onlyTrashed()->get()->count();

		// Get trashed mode
		$junked  = Input::get('path');

		return $this->view('admin.sentinel.pages.index')->data(compact('pages','deleted','junked'))->title('Pages Listing');
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
        $page = $this->pages->findOrFail($id);
        
        // Read ACL settings config for any permission access
        $acl = config('setting.acl');
	               	      
		// Set data to return
	   	$data = ['page'=>$page,'acl'=>$acl];

	   	// Return data and view
	   	return $this->view('admin.sentinel.pages.show')->data($data)->title('View Page'); 

	}

	/**
	 * Show the form for creating new page.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new page.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating page.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{					
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating page.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}
	
	/**
	 * Remove the specified page.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function trash($id)
	{
		if ($page = Page::find($id))
		{

			// Add deleted_at and not completely delete
			$page->delete();

			// Redirect with messages
			return Redirect::to(route('admin.pages.index'))->with('success', 'Page Trashed!');
		}

		return Redirect::to(route('admin.pages.index'))->with('error', 'Page Not Found!');;
	}

	/**
	 * Restored the specified setting.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restored($id)
	{
		if ($page = Page::onlyTrashed()->find($id))
		{

			// Restored back from deleted_at database
			$page->restore();

			// Redirect with messages
			return Redirect::to(route('admin.pages.index'))->with('success', 'Page Restored!');
		}

		return Redirect::to(route('admin.pages.index'))->with('error', 'Page Not Found!');
	}

	/**
	 * Remove the specified page.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($page = Page::onlyTrashed()->find($id))
		{

			// Completely delete from database
			$page->forceDelete();

			// Redirect with messages
			return Redirect::to(route('admin.pages.index'))->with('success', 'Page Permanently Deleted!');

		}

		return Redirect::to(route('admin.pages.index'))->with('error', 'Page Not Found!');;
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
			if ( ! $page = $this->pages->find($id))
			{
				return Redirect::to(route('admin.pages.index'));
			}
		}
		else
		{
			$page = $this->pages;
		}

		
		//$page_access = config('setting.acl');
		
		//$page = Sentinel::findPageById($this->user->pages()->first()->id);

		//dd (array_keys($page_access));

		// dd ($page->hasAccess('tasks'));
		
		return $this->view('admin.sentinel.pages.form')->data(compact('mode', 'page'))->title('Pages '.$mode);
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
		$input = Input::all();	 

		//dd ($input);

		if ($input['permissions'] === 'true') {

			$input['permissions'] = ['admin'=>true];

		} else {

			$input['permissions'] = ['admin'=>false];

		}

		$rules = [
			'name' => 'required',
			'slug' => 'required|unique:pages'
		];
		
		if ($id)
		{

			$page = $this->pages->find($id);

			$rules['slug'] .= ",slug,{$page->slug},slug";

			$messages = $this->validatePage($input, $rules);

			if ($messages->isEmpty())
			{
				$page->fill($input);

				$page->save();
			}
		}
		else
		{

			$messages = $this->validatePage($input, $rules);

			if ($messages->isEmpty())
			{	

				$page = $this->pages->create($input);				

			}
		}

		if ($messages->isEmpty())
		{
			return Redirect::to(route('admin.pages.index'))->with('success', 'Page Updated!');;
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

	/**
	 * Validates a page.
	 *
	 * @param  array  $data
	 * @param  mixed  $id
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validatePage($data, $rules)
	{
		$validator = Validator::make($data, $rules);

		$validator->passes();

		return $validator->errors();
	}

}
