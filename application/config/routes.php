<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Routes pour About Us (gestion de la casse)
$route['AboutUs'] = 'aboutus';
$route['AboutUs/index'] = 'aboutus/index';
$route['AboutUs/get_content'] = 'aboutus/get_content';
$route['AboutUs/update_content'] = 'aboutus/update_content';

// Routes normales
$route['aboutus'] = 'aboutus';
$route['aboutus/index'] = 'aboutus/index';
$route['aboutus/get_content'] = 'aboutus/get_content';
$route['aboutus/update_content'] = 'aboutus/update_content';

// Routes pour les blocs
$route['blocks/get_all'] = 'blocks/get_all';
$route['blocks/add'] = 'blocks/add';
$route['blocks/update_order'] = 'blocks/update_order';
$route['blocks/toggle_visibility'] = 'blocks/toggle_visibility';
$route['blocks/delete'] = 'blocks/delete';

// Routes pour Statistics
$route['statistics/get_content'] = 'statistics/get_content';
$route['statistics/update_content'] = 'statistics/update_content';
$route['statistics/toggle_visibility'] = 'Statistics/toggle_visibility';
$route['statistics'] = 'statistics/index';

// Routes pour FAQ
$route['faq/get_content'] = 'faq/get_content';
$route['faq/update_content'] = 'faq/update_content';
$route['faq/toggle_visibility'] = 'Faq/toggle_visibility';
$route['faq'] = 'faq/index';

// Routes pour l'administration
$route['admin'] = 'admin/index';
$route['admin/auth'] = 'auth/index';
$route['admin/auth/login'] = 'auth/login';
$route['admin/auth/logout'] = 'auth/logout';
$route['admin/directory'] = 'directories/index';
$route['admin/directory/get_directories'] = 'directories/get_directories';
$route['admin/directory/get_directories_new'] = 'directories/get_directories_new';
$route['admin/directory/add'] = 'directories/add';
$route['admin/directory/edit/(:num)'] = 'directories/edit/$1';
$route['admin/directory/delete/(:num)'] = 'directories/delete/$1';
$route['admin/directory/portfolio/(:num)'] = 'directories/portfolio/$1';

// Routes pour le profil
$route['admin/profile'] = 'profile/index';
$route['admin/profile/update'] = 'profile/update';

// Routes pour les services
$route['admin/services'] = 'services/index';
$route['admin/services/add'] = 'services/add';
$route['admin/services/edit/(:num)'] = 'services/edit/$1';
$route['admin/services/delete/(:num)'] = 'services/delete/$1';

// Routes pour les pages lead
$route['admin/pageslead'] = 'PageLeads/index';
$route['admin/pageslead/create'] = 'PageLeads/create';
$route['admin/pageslead/add'] = 'PageLeads/add';
$route['admin/pageslead/edit/(:num)'] = 'PageLeads/edit/$1';
$route['admin/pageslead/delete/(:num)'] = 'PageLeads/delete/$1';
$route['admin/pageslead/get_pages_lead_new'] = 'PageLeads/get_pages_lead_new';
// // Route publique pour afficher une page lead
$route['page/(:any)'] = 'PageLeads/view/$1';


$route['services/(:any)'] = 'Directories/getbyservice/$1';
$route['default_controller'] = 'Home';

$route['admin/settings'] = 'Settings/index';
$route['404_override'] = 'ErrorController/error404';
$route['(:any)'] = 'Home/view/$1';
$route['translate_uri_dashes'] = FALSE;
