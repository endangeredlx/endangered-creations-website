<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

// The first page to load on yoursite.com 
$route['default_controller'] = "run";
// You should leave blank unless you know what you're doing
$route['scaffolding_trigger'] = "";
// If you want to use blog instead of entries
$route['blog'] = 'entries';
// If you want to use blog instead of entries
$route['blog/:num'] = 'entries/listings/$1';
// If you want to use blog instead of entries
$route['blog/(.+)'] = 'entries/$1';  
// For non-id specific admin pages
$route['pages/(manage|write|create)'] = 'pages/$1';  
// For id specific pages
$route['pages/(edit|add_photo|remove|file_upload|update)/(.+)'] = 'pages/$1'; 
// Front-end pages 
$route['pages/(.+)'] = 'pages/evaluate/$1'; 

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */
