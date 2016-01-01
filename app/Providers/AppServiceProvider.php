<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

		// Returning the current class name and action
		app('view')->composer('admin.template', function($view)
	    {
	    	// $basename =  explode("@", str_replace('Controller','',class_basename(Route::getCurrentRoute()->getActionName())));
	        // $action = app('request')->route()->getAction();
			$action = app('request')->route()->getActionName();

	        // $controller = class_basename($action['controller']);
			$controller = class_basename($action);
 			 			
	        if (str_contains($controller, 'Controller@')) {

	        	list($controller, $action) = explode('Controller@', $controller);

	    	} else {

				// list($controller, $action) = explode('@', $controller);
				$controller = '';
				$action = '';

	    	}
	        
	       

        	$view->with(compact('controller', 'action'));

	    });
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
