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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['icd'] = 'welcome/icd';

$route['auth/login'] = 'auth/login';
$route['auth/do_login'] = 'auth/do_login';
$route['auth/logout'] = 'auth/logout';
$route['user'] = 'user/list';
$route['user/create'] = 'user/create';
$route['user/create-post'] = 'user/create_post';
$route['user/delete'] = 'user/delete';
$route['user/edit'] = 'user/edit';
$route['user/edit-post'] = 'user/edit_post';

$route['doctor'] = 'doctor/list';
$route['doctor/create'] = 'doctor/create';
$route['doctor/create-post'] = 'doctor/create_post';
$route['doctor/delete'] = 'doctor/delete';
$route['doctor/edit'] = 'doctor/edit';
$route['doctor/edit-post'] = 'doctor/edit_post';

$route['patient'] = 'patient/list';
$route['patient/create'] = 'patient/create';
$route['patient/create-post'] = 'patient/create_post';
$route['patient/delete'] = 'patient/delete';
$route['patient/edit'] = 'patient/edit';
$route['patient/edit-post'] = 'patient/edit_post';

$route['record'] = 'record/list';
$route['record/create'] = 'record/create';
$route['record/create-post'] = 'record/create_post';
$route['record/delete'] = 'record/delete';
$route['record/edit'] = 'record/edit';
$route['record/edit-post'] = 'record/edit_post';

$route['medical-record'] = 'medicalrecord/list';
$route['medical-record/diagnose'] = 'medicalrecord/diagnose';
$route['medical-record/diagnose-post'] = 'medicalrecord/diagnose_post';