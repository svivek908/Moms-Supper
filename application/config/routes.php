<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$ms_admin = 'Msa-';

//$route['Moms_login'] = 'Welcome/login';
$route['default_controller'] = 'Admin/Admin_login';
//-------------Mom supper admin route---------
$route[$ms_admin . "Login"] = 'Admin/Admin_login';
$route[$ms_admin . "Dashboard"] = 'Admin/Admin_dashboard';
$route[$ms_admin . "Users"] = 'Admin/Users';
$route[$ms_admin . "Moms"] = 'Admin/Moms';
$route[$ms_admin . "Moms/(:any)"] = 'Admin/Moms/index/$1';
$route[$ms_admin . "moms_list"] = 'Admin/Moms/moms_list';
$route[$ms_admin . "moms_list/(:any)"] = 'Admin/Moms/moms_list/$1';

$route[$ms_admin . "moms_menu"] = 'Admin/Moms/moms_menu';
$route[$ms_admin . "moms_menu/(:num)"] = 'Admin/Moms/moms_menu/$1';
$route[$ms_admin . "moms_menu_list"] = 'Admin/Moms/menu_list';
$route[$ms_admin . "moms_menu_list/(:num)"] = 'Admin/Moms/menu_list/$1';
$route[$ms_admin . "moms_status"] = 'Admin/Moms/change_status';

$route[$ms_admin . "Items"] = 'Admin/Menu_items';
$route[$ms_admin . "Items_list"] = 'Admin/Menu_items/item_list';
$route[$ms_admin . "Item_get_page/(:any)"] = 'Admin/Menu_items/open_page/$1';
$route[$ms_admin . "Edit_item"] = 'Admin/Menu_items/edit_item';
$route[$ms_admin . "Logout"] = 'Admin/Logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
