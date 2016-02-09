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
				// Admin modules will be in the Admin directory in Http
				['Admin' => [
						//------ Admin users controller
						['Users' => [
								// Action for first index
								'action' => ['users.index'],
								// Controller method list
								'method' => ['users.index','users.edit','users.update','users.create','users.trash','users.delete','users.restored','users.store','users.show','users.dashboard'],
							]
						],
						//------ Admin roles controller
						['Roles' => [ 						
								// Action for first index
								'action' => ['roles.index'],						
								// Controller method list
								'method' => ['roles.index','roles.edit','roles.update','roles.create','roles.trash','roles.delete','roles.restored','roles.store','roles.show']
							]
						],	
						//------ Admin permissions controller
						['Permissions' => [
								// Action for first index
								'action' => ['permissions.index'],
								// Controller method list
								'method' => ['permissions.index','permissions.edit','permissions.create','permissions.store','permissions.change','permissions.show']
							]
						],
						//------ Admin settings controller
						['Settings' => [
								// Action for first index
								'action' => ['settings.index'],						
								// Controller method list
								'method' => ['settings.index','settings.edit','settings.update','settings.create','settings.store','settings.trash','settings.delete','settings.restored','settings.show','settings.change']
							]
						],
						//------ Admin logs controller
						['Logs' => [
								// Action for first index
								'action' => ['logs.index'],						
								// Controller method list							
								'method' => ['logs.index','logs.edit','logs.create','logs.store','logs.show']					
							]
						]
					]
				],
				// Pages modules will be in the Admin directory in Http
				['Page' => [
						//------ Pages controller
						['Pages' => [
								// Action for first index
								'action' => ['pages.index'],
								// Controller method list
								'method' => ['pages.index','pages.edit','pages.update','pages.create','pages.store','pages.show'],
							]
						],
						//------ Menus controller
						['Menus' => [
								// Action for first index
								'action' => ['menus.index'],
								// Controller method list
								'method' => ['menus.index','menus.edit','menus.update','menus.create','menus.store','menus.show'],
							]
						],
					]
				],
				// Tasks modules will be in the directory in Http
				['Task' => [
						//------ Tasks controller
						['Tasks' => [
								// Action for first index
								'action' => ['tasks.index'],
								// Controller method list
								'method' => ['tasks.index','tasks.edit','tasks.update','tasks.create','tasks.store','tasks.trash','tasks.delete','tasks.restored','tasks.show']
							]
						]
					]
				],
				// Career modules will be in the Admin directory in Http
				['Career' => [
						//------ Tasks controller
						['Careers' => [
								// Action for first index
								'action' => ['careers.index'],
								// Controller method list
								'method' => ['careers.index','careers.edit','careers.update','careers.create','careers.store','careers.trash','careers.delete','careers.restored','careers.show']
							]
						]
					]
				],	
				// Participant modules will be in the Admin directory in Http
				['Participant' => [
						//------ Tasks controller
						['Participants' => [
								// Action for first index
								'action' => ['participants.index'],
								// Controller method list
								'method' => ['participants.index','participants.edit','participants.update','participants.create','participants.store','participants.trash','participants.delete','participants.restored','participants.show']
							]
						]
					]
				]	
			 ],


 	/*	 
	 |--------------------------------------------------------------------------
	 | Users attributes default in administrator panel
	 |--------------------------------------------------------------------------
	 | 
	 | Modify or add new configuration
	 | Always add new array [attribute],[value] for registering new attribute
	 |
	 */
	 
	 'attributes' => 
		['skins' => 
			['#438EB9' => true, '#222A2D' => false, '#C6487E' => false, '#D0D0D0' => false]
	 	],
	 	['show_email' => 
	 		['Yes' => 1, 'No' => 0]
	 	],	 	
	 	['show_profile' => 
	 		['Yes' => 1, 'No' => 0]
	 	],
	
	/*	 
	 |--------------------------------------------------------------------------
	 | Table status inactive or active attributes default in administrator panel
	 |--------------------------------------------------------------------------
	 | 
	 | Modify or add new configuration
	 | Always add new array [attribute],[value] for registering new attribute
	 |
	 */
	 'status' => 
		[
			'Active' => 1,
			'Inactive' => 0
		],

	'configure'	=> []
];
