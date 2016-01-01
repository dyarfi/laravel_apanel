<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');
//Route::get('home', 'HomeController@index');

// Front routes endpoint for home page
Route::get('/', [
    'as' => 'home',
    'uses' => 'PagesController@home'
]);


// Public User routes ...
//Route::get('user', 'UsersController@index');
//Route::post('user/edit', 'UsersController@edit');
//Route::get('user', 'UsersController@profile');
//Route::get('profile', 'UsersController');
//Route::get('profile/update', 'UsersController@update');

//Route::get('profile', array('as' => 'profile', 'uses' => 'UsersController'));
//Route::get('profile', array('as' => 'profile', 'uses' => 'UsersController@showProfile'));

//Route::get('profile/edit', 'UsersController@edit');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

//Route::get('auth/social',

// Front routes endpoint resources
Route::resource('tasks', 'TasksController');
Route::resource('users', 'UsersController');

// Disable checkpoints (throttling, activation) for demo purposes
Sentinel::disableCheckpoints();

/* **************************************
 * 
 * Load Administrator config setting
 *
 * **************************************
 */

// Load config/setting.php file
$setting = config('setting');

// Share a var with all views : $admin_url
View::share('admin_url', $setting['admin_url']);

// Share a var with all views : $admin_url
View::share('admin_app', $setting['admin_app']);

// Share a var with all views : $admin_url
View::share('company_name', $setting['company_name']);

// ******************* Admin Routes ********************* { //
/*
 * 
 * Administrator panel routes
 *
 */
Route::group(['prefix' => $setting['admin_url']], function()
{
    // ******************* Shortcut for Developer Setup ******************** //

    // Get main administrator lgin
    Route::get('setup/first/migrate', 'Admin\BaseAdmin@setup');
    Route::post('setup/first/migrate', 'Admin\BaseAdmin@setup');

    // Get no access pages
    Route::get('noaccess', ['as'=>'admin.noaccess','uses'=>'Admin\BaseAdmin@unauthorize']);
    Route::get('noaccess', ['as'=>'admin.access.index','uses'=>'Admin\BaseAdmin@index']);

    // ******************* Auth\AuthAdminController ********************* { //

    // Get main administrator lgin
    Route::get('/', 'Auth\AuthAdminController@index');
        
    // ByPass to admin auth controller in middleware | Login
    Route::get('login', [ 'as' => 'admin.login', 'uses' => 'Auth\AuthAdminController@login']);
    Route::post('login', 'Auth\AuthAdminController@processLogin');

    // ByPass to admin auth controller in middleware | Logout    
    Route::get('logout', 'Auth\AuthAdminController@logout');
    
    // ByPass to admin auth controller in middleware | Register
    Route::get('register', 'Auth\AuthAdminController@register');
    Route::post('register', 'Auth\AuthAdminController@processRegistration');

    // } ****************** Auth\AuthAdminController ****************** //

    // Users Controller    
    Route::get('account', ['as'=>'users','uses'=>'Admin\UsersController@profile']);
    
    // User related routes
    Route::get('users', ['as'=>'admin.users.index','uses'=>'Admin\UsersController@index']);
    Route::get('users/create', ['as'=>'admin.users.create', 'uses'=>'Admin\UsersController@create']);
    Route::post('users/create', ['as'=>'admin.users.store', 'uses'=>'Admin\UsersController@store']);
    Route::get('users/{id}/show', ['as'=>'admin.users.show', 'uses'=>'Admin\UsersController@show']);
    Route::get('users/{id}', ['as'=>'admin.users.edit', 'uses'=>'Admin\UsersController@edit']);
    Route::post('users/{id}', ['as'=>'admin.users.update', 'uses'=>'Admin\UsersController@update']);
    Route::get('users/{id}/trash', ['as'=>'admin.users.trash','uses'=>'Admin\UsersController@trash']);    
    Route::get('users/{id}/restored', ['as'=>'admin.users.restored','uses'=>'Admin\UsersController@restored']);
    Route::get('users/{id}/delete', ['as'=>'admin.users.delete','uses'=>'Admin\UsersController@delete']);

    // Permissions Controller routes
    Route::get('permissions', ['as'=>'admin.permissions.index','uses'=>'Admin\PermissionsController@index']);
    Route::get('permissions/create', ['as'=>'admin.permissions.create','uses'=>'Admin\PermissionsController@create']);
    Route::post('permissions/create', ['as'=>'admin.permissions.store','uses'=>'Admin\PermissionsController@store']);
    Route::get('permissions/{id}', ['as'=>'admin.permissions.edit','uses'=>'Admin\PermissionsController@edit']);
    Route::post('permissions/{id}', ['as'=>'admin.permissions.update','uses'=>'Admin\PermissionsController@update']);
    Route::get('permissions/{id}/delete', ['as'=>'admin.permissions.delete','uses'=>'Admin\PermissionsController@delete']);
    // Ajax Controller
    Route::post('permissions/{id}/change', ['as'=>'admin.permissions.change','uses'=>'Admin\PermissionsController@change']);

    // Roles Controller routes
    Route::get('roles', ['as'=>'admin.roles.index','uses'=>'Admin\RolesController@index']);
    Route::get('roles/create', ['as'=>'admin.roles.create','uses'=>'Admin\RolesController@create']);
    Route::post('roles/create', ['as'=>'admin.roles.store','uses'=>'Admin\RolesController@store']);
    Route::get('roles/{id}/show', ['as'=>'admin.roles.show', 'uses'=>'Admin\RolesController@show']);
    Route::get('roles/{id}', ['as'=>'admin.roles.edit','uses'=>'Admin\RolesController@edit']);
    Route::post('roles/{id}', ['as'=>'admin.roles.update','uses'=>'Admin\RolesController@update']);
    Route::get('roles/{id}/trash', ['as'=>'admin.roles.trash','uses'=>'Admin\RolesController@trash']);    
    Route::get('roles/{id}/restored', ['as'=>'admin.roles.restored','uses'=>'Admin\RolesController@restored']);
    Route::get('roles/{id}/delete', ['as'=>'admin.roles.delete','uses'=>'Admin\RolesController@delete']);

    // Settings Controller routes
    Route::get('settings', ['as'=>'admin.settings.index','uses'=>'Admin\SettingsController@index']);
    Route::get('settings/create', ['as'=>'admin.settings.create','uses'=>'Admin\SettingsController@create']);
    Route::post('settings/create', ['as'=>'admin.settings.store','uses'=>'Admin\SettingsController@store']);
    Route::get('settings/{id}/show', ['as'=>'admin.settings.show', 'uses'=>'Admin\SettingsController@show']);
    Route::get('settings/{id}', ['as'=>'admin.settings.edit','uses'=>'Admin\SettingsController@edit']);
    Route::post('settings/{id}', ['as'=>'admin.settings.update','uses'=>'Admin\SettingsController@update']);
    Route::get('settings/{id}/trash', ['as'=>'admin.settings.trash','uses'=>'Admin\SettingsController@trash']);
    Route::get('settings/{id}/restored', ['as'=>'admin.settings.restored','uses'=>'Admin\SettingsController@restored']);
    Route::get('settings/{id}/delete', ['as'=>'admin.settings.delete','uses'=>'Admin\SettingsController@delete']);
    
    // Logs Controller routes
    Route::get('logs', ['as'=>'admin.logs.index','uses'=>'Admin\LogsController@index']);
    Route::get('logs/create', ['as'=>'admin.logs.create','uses'=>'Admin\LogsController@create']);
    Route::post('logs/create', ['as'=>'admin.logs.store','uses'=>'Admin\LogsController@store']);
    Route::get('logs/{id}/show', ['as'=>'admin.logs.show', 'uses'=>'Admin\LogsController@show']);
    Route::get('logs/{id}', ['as'=>'admin.logs.edit','uses'=>'Admin\LogsController@edit']);
    Route::post('logs/{id}', ['as'=>'admin.logs.update','uses'=>'Admin\LogsController@update']);
    Route::get('logs/{id}/trash', ['as'=>'admin.logs.trash','uses'=>'Admin\LogsController@trash']);    
    Route::get('logs/{id}/restored', ['as'=>'admin.logs.restored','uses'=>'Admin\LogsController@restored']);
    Route::get('logs/{id}/delete', ['as'=>'admin.logs.delete','uses'=>'Admin\LogsController@delete']);

    // Get admin panel controllers routes
    Route::get('profile', 'Admin\UsersController@profile');

    // Get admin panel controllers routes
    Route::get('dashboard', 'Admin\UsersController@dashboard');
    
    // Pages Controller routes
    Route::get('pages', ['as'=>'admin.pages.index','uses'=>'Admin\PagesController@index']);
    Route::get('pages/create', ['as'=>'admin.pages.create','uses'=>'Admin\PagesController@create']);
    Route::post('pages/create', ['as'=>'admin.pages.store','uses'=>'Admin\PagesController@store']);
    Route::get('pages/{id}/show', ['as'=>'admin.pages.show', 'uses'=>'Admin\PagesController@show']);
    Route::get('pages/{id}', ['as'=>'admin.pages.edit','uses'=>'Admin\PagesController@edit']);
    Route::post('pages/{id}', ['as'=>'admin.pages.update','uses'=>'Admin\PagesController@update']);
    Route::get('pages/{id}/trash', ['as'=>'admin.pages.trash','uses'=>'Admin\PagesController@trash']);    
    Route::get('pages/{id}/restored', ['as'=>'admin.pages.restored','uses'=>'Admin\PagesController@restored']);
    Route::get('pages/{id}/delete', ['as'=>'admin.pages.delete','uses'=>'Admin\PagesController@delete']);

    // Menus Controller routes
    Route::get('menus', ['as'=>'admin.menus.index','uses'=>'Admin\MenusController@index']);
    Route::get('menus/create', ['as'=>'admin.menus.create','uses'=>'Admin\MenusController@create']);
    Route::post('menus/create', ['as'=>'admin.menus.store','uses'=>'Admin\MenusController@store']);
    Route::get('menus/{id}/show', ['as'=>'admin.menus.show', 'uses'=>'Admin\MenusController@show']);
    Route::get('menus/{id}', ['as'=>'admin.menus.edit','uses'=>'Admin\MenusController@edit']);
    Route::post('menus/{id}', ['as'=>'admin.menus.update','uses'=>'Admin\MenusController@update']);
    Route::get('menus/{id}/trash', ['as'=>'admin.menus.trash','uses'=>'Admin\MenusController@trash']);    
    Route::get('menus/{id}/restored', ['as'=>'admin.menus.restored','uses'=>'Admin\MenusController@restored']);
    Route::get('menus/{id}/delete', ['as'=>'admin.menus.delete','uses'=>'Admin\MenusController@delete']);

    // Tasks Controller routes
    Route::get('tasks', ['as'=>'admin.tasks.index','uses'=>'Admin\TasksController@index']);
    Route::get('tasks/create', ['as'=>'admin.tasks.create','uses'=>'Admin\TasksController@create']);
    Route::post('tasks/create', ['as'=>'admin.tasks.store','uses'=>'Admin\TasksController@store']);
    Route::get('tasks/{id}/show', ['as'=>'admin.tasks.show', 'uses'=>'Admin\TasksController@show']);
    Route::get('tasks/{id}', ['as'=>'admin.tasks.edit','uses'=>'Admin\TasksController@edit']);
    Route::post('tasks/{id}', ['as'=>'admin.tasks.update','uses'=>'Admin\TasksController@update']);
    Route::get('tasks/{id}/trash', ['as'=>'admin.tasks.trash','uses'=>'Admin\TasksController@trash']);    
    Route::get('tasks/{id}/restored', ['as'=>'admin.tasks.restored','uses'=>'Admin\TasksController@restored']);
    Route::get('tasks/{id}/delete', ['as'=>'admin.tasks.delete','uses'=>'Admin\TasksController@delete']);

    // Participants Controller routes
    Route::get('participants', ['as'=>'admin.participants.index','uses'=>'Admin\ParticipantsController@index']);
    Route::get('participants/create', ['as'=>'admin.participants.create','uses'=>'Admin\ParticipantsController@create']);
    Route::post('participants/create', ['as'=>'admin.participants.store','uses'=>'Admin\ParticipantsController@store']);
    Route::get('participants/{id}/show', ['as'=>'admin.participants.show', 'uses'=>'Admin\ParticipantsController@show']);
    Route::get('participants/{id}', ['as'=>'admin.participants.edit','uses'=>'Admin\ParticipantsController@edit']);
    Route::post('participants/{id}', ['as'=>'admin.participants.update','uses'=>'Admin\ParticipantsController@update']);
    Route::get('participants/{id}/trash', ['as'=>'admin.participants.trash','uses'=>'Admin\ParticipantsController@trash']);    
    Route::get('participants/{id}/restored', ['as'=>'admin.participants.restored','uses'=>'Admin\ParticipantsController@restored']);
    Route::get('participants/{id}/delete', ['as'=>'admin.participants.delete','uses'=>'Admin\ParticipantsController@delete']);

});

/*
// Display all SQL executed in Eloquent
Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});
*/

// ******************* Admin Routes ********************* } //


/*
Route::group(['prefix' => 'apanel/roles'], function()
{
    Route::get('/', 'Admin\RolesController@index');
    Route::get('create', 'Admin\RolesController@create');
    Route::post('create', 'Admin\RolesController@store');
    Route::get('{id}', 'Admin\RolesController@edit');
    Route::post('{id}', 'Admin\RolesController@update');
    Route::get('{id}/delete', 'Admin\RolesController@delete');
});
*/

//Route::get('profile', 'UsersController@profile');
/*
Route::get('users/edit/{id}', [
    'as' => 'users.edit', 'uses' => 'UsersController@edit'
]);
Route::get('users/show/{id}', [
    'as' => 'users.show', 'uses' => 'UsersController@show'
]);
Route::get('users', [
    'as' => 'users.index', 'uses' => 'UsersController@index'
]);
Route::get('users/create', [
    'as' => 'users.create', 'uses' => 'UsersController@create'
]);
Route::get('users/destroy', [
    'as' => 'users.destroy', 'uses' => 'UsersController@destroy'
]);
Route::get('profile', [
    'as' => 'profile', 'uses' => 'UsersController@profile'
]);
Route::get('profile/update', [
    'as' => 'profile.update', 'uses' => 'UsersController@update'
]);
*/


Route::get('auth/social/{provider}', 'AuthSocialController@redirectToProvider');
Route::get('auth/social', 'AuthSocialController@handleProviderCallback');

//Route::get('login/{provider}', 'Auth\AuthController@login');

//Route::resource('auth', 'AuthController');

Route::get('wait', function()
{
    return View::make('sentinel.wait');
});

Route::get('activate/{id}/{code}', function($id, $code)
{
    $user = Sentinel::findById($id);

    if ( ! Activation::complete($user, $code))
    {
        return Redirect::to("login")
            ->withErrors('Invalid or expired activation code.');
    }

    return Redirect::to('login')
        ->withSuccess('Account activated.');
})->where('id', '\d+');

Route::get('reactivate', function()
{
    if ( ! $user = Sentinel::check())
    {
        return Redirect::to('login');
    }

    $activation = Activation::exists($user) ?: Activation::create($user);

    // This is used for the demo, usually you would want
    // to activate the account through the link you
    // receive in the activation email
    Activation::complete($user, $activation->code);

    // $code = $activation->code;

    // $sent = Mail::send('sentinel.emails.activate', compact('user', 'code'), function($m) use ($user)
    // {
    //  $m->to($user->email)->subject('Activate Your Account');
    // });

    // if ($sent === 0)
    // {
    //  return Redirect::to('register')
    //      ->withErrors('Failed to send activation email.');
    // }

    return Redirect::to('account')
        ->withSuccess('Account activated.');
})->where('id', '\d+');

Route::get('deactivate', function()
{
    $user = Sentinel::check();

    Activation::remove($user);

    return Redirect::back()
        ->withSuccess('Account deactivated.');
});

Route::get('reset', function()
{
    return View::make('sentinel.reset.begin');
});

Route::post('reset', function()
{
    $rules = [
        'email' => 'required|email',
    ];

    $validator = Validator::make(Input::get(), $rules);

    if ($validator->fails())
    {
        return Redirect::back()
            ->withInput()
            ->withErrors($validator);
    }

    $email = Input::get('email');

    $user = Sentinel::findByCredentials(compact('email'));

    if ( ! $user)
    {
        return Redirect::back()
            ->withInput()
            ->withErrors('No user with that email address belongs in our system.');
    }

    // $reminder = Reminder::exists($user) ?: Reminder::create($user);

    // $code = $reminder->code;

    // $sent = Mail::send('sentinel.emails.reminder', compact('user', 'code'), function($m) use ($user)
    // {
    //  $m->to($user->email)->subject('Reset your account password.');
    // });

    // if ($sent === 0)
    // {
    //  return Redirect::to('register')
    //      ->withErrors('Failed to send reset password email.');
    // }

    return Redirect::to('wait');
});

Route::get('reset/{id}/{code}', function($id, $code)
{
    $user = Sentinel::findById($id);

    return View::make('sentinel.reset.complete');

})->where('id', '\d+');

Route::post('reset/{id}/{code}', function($id, $code)
{
    $rules = [
        'password' => 'required|confirmed',
    ];

    $validator = Validator::make(Input::get(), $rules);

    if ($validator->fails())
    {
        return Redirect::back()
            ->withInput()
            ->withErrors($validator);
    }

    $user = Sentinel::findById($id);

    if ( ! $user)
    {
        return Redirect::back()
            ->withInput()
            ->withErrors('The user no longer exists.');
    }

    if ( ! Reminder::complete($user, $code, Input::get('password')))
    {
        return Redirect::to('login')
            ->withErrors('Invalid or expired reset code.');
    }

    return Redirect::to('login')
        ->withSuccess("Password Reset.");
})->where('id', '\d+');

Route::group(['prefix' => 'account', 'before' => 'auth'], function()
{

    Route::get('/', function()
    {
        $user = Sentinel::getUser();

        $persistence = Sentinel::getPersistenceRepository();

        return View::make('sentinel.account.home', compact('user', 'persistence'));
    });

    Route::get('kill', function()
    {
        $user = Sentinel::getUser();

        Sentinel::getPersistenceRepository()->flush($user);

        return Redirect::back();
    });

    Route::get('kill-all', function()
    {
        $user = Sentinel::getUser();

        Sentinel::getPersistenceRepository()->flush($user, false);

        return Redirect::back();
    });

    Route::get('kill/{code}', function($code)
    {
        Sentinel::getPersistenceRepository()->remove($code);

        return Redirect::back();
    });

});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password forgotten routes...
Route::get('auth/password/email','Auth\PasswordController@getEmail');
Route::post('auth/password/email','Auth\PasswordController@postEmail');
//Route::post('auth/register', 'Auth\AuthController@postRegister');