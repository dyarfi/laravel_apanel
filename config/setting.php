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

	/*	 
	 |--------------------------------------------------------------------------
	 | Access Controller Lists in administrator panel
	 |--------------------------------------------------------------------------
	 | 
	 | Modify or add new configuration
	 | Always add new array [action],[controller] for registering new controller
	 |
	 */

	'acl' => [
				// Admin modules will be in the directory in Http
				['Admin' => [
						//------ Admin users controller
						['Users' => [
								// Action list
								'action' => ['users.index'],
								// Controller list
								'method' => ['users.index','users.edit','users.update','users.create','users.trash','users.delete','users.restored','users.store','users.show','users.dashboard'],
							]
						],
						//------ Admin roles controller
						['Roles' => [ 						
								// Action list
								'action' => ['roles.index'],						
								// Controller list
								'method' => ['roles.index','roles.edit','roles.update','roles.create','roles.trash','roles.delete','roles.restored','roles.store','roles.show']
							]
						],	
						//------ Admin permissions controller
						['Permissions' => [
								// Action list
								'action' => ['permissions.index'],
								// Controller list
								'method' => ['permissions.index','permissions.edit','permissions.create','permissions.store','permissions.change','permissions.show']
							]
						],
						//------ Admin settings controller
						['Settings' => [
								// Action list
								'action' => ['settings.index'],						
								// Controller list
								'method' => ['settings.index','settings.edit','settings.update','settings.create','settings.store','settings.trash','settings.delete','settings.restored','settings.show']
							]
						],
						//------ Admin logs controller
						['Logs' => [
								// Action list
								'action' => ['logs.index'],						
								// Controller list							
								'method' => ['logs.index','logs.edit','logs.create','logs.store','logs.show']					
							]
						]
					]
				],
				// Pages modules will be in the directory in Http
				['Page' => [
						//------ Pages controller
						['Pages' => [
								// Action list
								'action' => ['pages.index'],
								// Controller list
								'method' => ['pages.index','pages.edit','pages.update','pages.create','pages.store','pages.show','pages.dashboard'],
							]
						],
						//------ Menus controller
						['Menus' => [
								// Action list
								'action' => ['menus.index'],
								// Controller list
								'method' => ['menus.index','menus.edit','menus.update','menus.create','menus.store','menus.show','menus.dashboard'],
							]
						],
					]
				]	
			 ]
];
