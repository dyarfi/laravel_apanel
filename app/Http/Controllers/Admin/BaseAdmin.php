<?php namespace Tasks\Http\Controllers\Admin;

// Load Laravel classes
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request, Session, Input, URL, View, Route;

abstract class BaseAdmin extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	/**
	* Master layout
	* @var string
	*/
		//protected $layout = 'admin.layouts.master';
		protected $layout = 'admin.template';
	 
	 /**
	* View to render
	* @var string
	*/
		protected $view;
	 
	 /**
	* Array of data passed to view
	* @var array
	*/
		protected $data = array();
	 
	 /**
	* Subview to render
	* @var string
	*/
		protected $subview;
	 
	 /**
	* Array of data to be passed to subview
	* @var array
	*/
		protected $subdata = array();
	 
	 /**
	* Page title
	* @var string
	*/
		protected $title;
	 
	 /**
	* Set default subview layout
	* @param string $sublayout
	*/
	 public function __construct($sublayout = null)
	 {	 	
		$this->view = $sublayout;		
	 }
	 
	 /**
	* Set view to render
	* @param string $view
	* @return self
	*/
	 protected function view($view)
	 {
		$this->view = $view;
	 	return $this;
	 }
	 
	 /**
	* Set data to pass to view
	* @param array $data
	* @return self
	*/
	 protected function data(array $data)
	 {
		$this->data = $data;
	 	return $this;
	 }
	 
	 /**
	* Set subview to render
	* @param string $subview
	* @return self
	*/
	 protected function subview($subview)
	 {
		$this->subview = $subview;
	 	return $this;
	 }
	 
	 /**
	* Set data to pass to subview
	* @param array $subdata
	* @return self
	*/
	 protected function subdata(array $subdata)
	 {
		$this->subdata = $subdata;
	 	return $this;
	 }
	 
	 /**
	* Set page title
	* @param string $title
	* @return Response
	*/
	 protected function title($title)
	 {
		$this->title = $title;
	 
		 // title method must be called last so it can call the render method
		 // this allows us to skip calling the render method
		 return $this->render();
	 }
	 
	 /**
	* Render the subview
	* @return Response
	*/
	 private function rendersubview()
	 {
		$this->subview = array('subview' => View::make($this->subview)->with($this->subdata));
	 
		 // append subview data to view data
		 return $this->data = $this->data + $this->subview;
	 }
	 
	 /**
	* Render the view
	* @return Response
	*/
	 private function render()
	 {
		 // render subview if subview is passed
		 (is_null($this->subview)) ? : $this->rendersubview();
		 
		 // render the view
		 return View::make($this->layout)
		 ->nest('content', $this->view, $this->data)
		 ->with('title', $this->title);
	 }

}
