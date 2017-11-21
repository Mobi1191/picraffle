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

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/

$route['signup'] = 'login/signup';
$route['signupMe'] = 'login/signupMe';
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";

$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

/* End of file routes.php */
/* Location: ./application/config/routes.php */

/*customer*/

$route['customer/myprofile'] = 'customer/profile';
$route['customer/editmyprofile'] = 'customer/editprofile';
$route['customer/contests'] = 'customer/contests';
$route['customer/viewcontest/(:num)'] = 'customer/viewcontest/$1';
$route['customer/todaycontest'] = 'customer/todaycontest';
$route['customer/uploadimage'] = 'customer/uploadimage';

/*admin*/

$route['admin/contests'] = 'admin/contests';
$route['admin/todaycontest'] = 'admin/todaycontest';
$route['admin/editcontest'] = 'admin/editcontest';
$route['admin/viewcontest/(:num)'] = 'admin/viewcontest/$1';
$route['admin/own/(:num)/(:num)/(:num)'] = 'admin/own/$1/$2/$3';
$route['admin/notification'] = 'admin/notification';
$route['admin/send_notification'] = 'admin/sendNotification';
$route['admin/edit_notification'] = 'admin/editNotification';


/*backend*/
$route['backend/login'] = 'backend/login';
$route['backend/signup'] = 'backend/signup';
$route['backend/gettodaytickets'] = 'backend/todaytickets';
$route['backend/getticketsbyuserid/(:num)'] = 'backend/getticketsbyuserid/$1';
$route['backend/getpastwinners'] = 'backend/getpastwinners';
$route['backend/gettodaycontestinfo'] = 'backend/gettodaycontestinfo';
$route['backend/contestupload'] = 'backend/contestupload';
$route['backend/getbraintreetoken'] = 'backend/getbraintreetoken';
$route['backend/maketransaction'] = 'backend/maketransaction';
$route['backend/getuserinfo'] = 'backend/getuserinfo';
$route['backend/changeusername'] = 'backend/changeusername';
$route['backend/changeemail'] = 'backend/changeemail';
$route['backend/changepassword'] = 'backend/changepassword';
$route['backend/deleteuser'] = 'backend/deleteuser';
$route['backend/adddevicetoken'] = 'backend/addDeviceToken';