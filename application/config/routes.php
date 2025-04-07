<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Home';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

// Authentication and Access Control
$route['access/css'] = 'Misc/check_session_status';
$route['access/login']['post'] = 'Home/login';

// Database Management
$route['dbmanagement'] = 'Misc/dbmanagement';

// User Login Routes
$route['userlogin'] = 'UserLoginController/index';
$route['userlogin/auth'] = 'UserLoginController/authenticate';

// Manufacturer Routes
$route['manufacturer/lmlt'] = 'Manufacturer/lmlt';
$route['category/loadCategoryList'] = 'Category/loadCategoryList';
