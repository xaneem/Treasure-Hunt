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
|	example.com/class/method/id/
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = '';

//These routes are used to simplify the code to just one home controller
//Although not exactly considered best practice for an MVC system, I chose to do it this way
$route['login'] = "home/login";
$route['logout'] = "home/logout";
$route['answer'] = "home/answer";
$route['signup'] = "home/signup";
$route['leaderboard'] = "home/leaderboard";
$route['winners'] = "home/winners";
$route['rules'] = "home/rules";

//:any is used when url_segments are required to be read
$route['profile'] = "home/profile";
$route['profile/(:any)'] = "home/profile";

//levels is used to display images securely
//Have a look at levels function in home controller
$route['levels/(:any)'] = "home/levels";


/* End of file routes.php */
/* Location: ./application/config/routes.php */