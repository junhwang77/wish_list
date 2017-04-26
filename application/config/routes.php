<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['dashboard'] = 'items/dashboard';
$route['wish_items/create'] = 'items/add_item';
$route['create'] = 'items/create_item';
$route['join/(:any)'] = 'items/wish_list_join/$1';
$route['remove/(:any)'] = 'items/remove_wish/$1';
$route['wish_items/(:any)'] = 'items/show_item/$1';
$route['destroy/(:any)'] = 'items/destroy/$1';
