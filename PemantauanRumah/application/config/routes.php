<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'C_Home/loadLogin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'C_Home/loadLogin';
$route['login-process'] = 'C_Home/loginProcess';
$route['logout'] = 'C_Home/logout';

$route['home'] = 'C_Home/loadHome';

$route['history'] = 'C_Home/loadHistorySearch';
$route['filterMonitoring'] = 'C_Home/filterSearch';
