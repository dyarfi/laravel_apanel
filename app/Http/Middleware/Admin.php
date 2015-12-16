<?php namespace App\Http\Middleware;

use Closure;
//use Illuminate\Contracts\Auth\Guard;
use App\Db\User;
use Illuminate\Routing\Router;
use Sentinel;
use Response;
use Route;
use Redirect;


class Admin {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	//protected $auth;
	protected $router;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Router  $router
	 * @return void
	 */
    public function __construct(User $user, Router $router)
    {
        $this->router = $router;
    }

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		// Get controller and action from request
		$action 		= $this->router->getRoutes()->match($request)->getActionName();

		// Get class name and action
		$class 			= class_basename(strtolower($action));

		// Explode controller and action
		$access 		= explode("controller@", $class);
		
		// Glues controller and action for checking
		$accessRoutes 	= join('.', $access);	
		
		if (! Sentinel::check()) {
			
			return Redirect::to('apanel/noaccess')->withErrors(['Only admins can access this page.']);

		} else if (Sentinel::hasAccess($accessRoutes)) {

			return $next($request);

		} else {

			return Redirect::to('apanel/noaccess')->withErrors(['Luke.. you do not have access permission to this page!']);
		}

		return $next($request);

	}

}
