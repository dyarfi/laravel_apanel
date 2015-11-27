<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'Db\App\User',
		'secret' => '',
	],

	'twitter' => [
	    'client_id' => 'dqu99PRCefOCpNPobQEvtBJpS',
	    'client_secret' => 'EXOPAceSDF7GNzaLXunByOClXLu0sGVxxAgxbyesLLSfYLcDLv',
	    'redirect' => 'http://localhost/laravel_tasks/public/auth/social?provider=twitter'
	],
	
	'linkedin' => [
		'client_id' => '75blw6tuiaom3x', 
		'client_secret' => 'rJMdMWsbpe2ixl9d',
		'redirect' => 'http://localhost/laravel_tasks/public/auth/social?provider=linkedin'
	],
	
	'google' => [
		'client_id' => '135018674898-re8sd5nigbbuh30p19k8ca3nfv8qbsuk.apps.googleusercontent.com', 
		'client_secret' => 'iNxgUKBfzDtxYxNy0tAXg95U',
		'redirect' => 'http://127.0.0.1/laravel_tasks/public/auth/social?provider=google'
	]
];
