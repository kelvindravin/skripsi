<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'C_Home/loadHome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['home'] = 'C_Home/loadHome';

$route['history'] = 'C_Home/loadHistorySearch';
$route['filterMonitoring'] = 'C_Home/filterSearch';

$route['about'] = 'C_Home/loadAbout';
