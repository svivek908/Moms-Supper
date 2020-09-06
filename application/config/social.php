<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Facebook API Configuration
| -------------------------------------------------------------------
|
| To get Facebook app details you have to create a Facebook app
| at Facebook developers panel (https://developers.facebook.com)
|
*/
$config['facebook_app_id']              = '154454972560983';
$config['facebook_app_secret']          = '180afa7ea195eea1961357a6e8a7332c';
$config['facebook_login_redirect_url']  = 'Moms_login/';
$config['facebook_login_type']          = 'web';
$config['facebook_permissions']         = array('email');
$config['facebook_graph_version']       = 'v2.6';
$config['facebook_auth_on_load']        = TRUE;

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
|
| To get Google app details you have to create a Google app
| at Google developers console (https://console.developers.google.com)
|
*/
$config['google_client_id']     = '255626090558-c55ri1t4hu9tnuv4nr8j10lg4u0qlmon.apps.googleusercontent.com';
$config['google_client_secret'] = 'LgPPWDaPHVTih2EQSz_EBtt4';
$config['google_redirect_url']  = 'users/login/';

/*
| -------------------------------------------------------------------
|  Twitter API Configuration
| -------------------------------------------------------------------
|
| To get Twitter app details you have to create a Twitter app
| at Twitter Application Management panel (https://apps.twitter.com)
|
*/
/*$config['twitter_api_key']     	= 'InsertTwitterAPIKey';
$config['twitter_api_secret'] 	= 'InsertTwitterAPISecret';
$config['twitter_redirect_url'] = 'users/login/';*/