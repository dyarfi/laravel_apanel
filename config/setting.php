<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Administrator panel settings
	|--------------------------------------------------------------------------
	|
	| Change this settings to desire name and defaults
	| this will be the url for administration CMS 
	| 
	|
	*/

	// Company name default
	'company_name'	=> 'Company Name',

	// Administrator label name
	'admin_app' => 'Admin Panel',
	
	// Administrator url
	'admin_url' => 'apanel',

	// Access Controller Lists in administrator panel
	'acl'		=> [
					// Admin users controller
					'Users' => ['users.index','users.edit','users.update','users.create','users.store','users.show','users.dashboard'],					
					// Admin roles controller
					'Roles' => ['roles.index','roles.edit','roles.update','roles.create','roles.trash','roles.delete','roles.restored','roles.store','roles.show'],
					// Admin permissions controller
					'Permissions' => ['permissions.index','permissions.edit','permissions.create','permissions.store','permissions.change','permissions.show'],
					// Admin settings controller
					'Settings' => ['settings.index','settings.edit','settings.update','settings.create','settings.store','settings.trash','settings.delete','settings.restored','settings.show'],
					// Admin logs controller
					'Logs' => ['logs.index','logs.edit','logs.create','logs.store','logs.show']					
					]
];
