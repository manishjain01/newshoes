<?php

return [

	'client_id' 	=> env('INSTAGRAM_API_KEY'),
	'client_secret' => env('INSTAGRAM_API_SECRET'),
	'redirect_uri' 	=> env('INSTAGRAM_REDIRECT_URI'),
	'scopes'		=> 'basic public_content'

];	