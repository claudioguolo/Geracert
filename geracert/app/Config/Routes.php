<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Main');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Main::index');
$routes->get('/locale/(:segment)', 'Main::setLocale/$1');
$routes->get('/pregeracert', 'Main::pregeracert');
$routes->get('/tablecerts', 'Main::tablecerts');
$routes->get('/login', 'Login::index');
$routes->post('/login/signIn', 'Login::signIn');
$routes->post('/login/signOut', 'Login::signOut');
//$routes->get('/geracert', 'Extra::geracert');
//$routes->get('/certeditor', 'Admin::certeditor');
//$routes->get('/geracert/(:any)', 'Extra::geracert/$1');
$routes->get('/pregeracert/(:any)', 'Main::pregeracert/$1');
//$routes->get('/login', 'Login::login');

$routes->group('', ['filter' => 'auth:admin.dashboard'], static function ($routes) {
    $routes->get('/admin', 'Admin::index');
});

$routes->group('certificado', ['filter' => 'auth:certificado.manage'], static function ($routes) {
    $routes->get('', 'Certificado::index');
    $routes->get('create', 'Certificado::create');
    $routes->post('store', 'Certificado::store');
    $routes->get('edit/(:num)', 'Certificado::edit/$1');
    $routes->post('delete/(:num)', 'Certificado::delete/$1');
    $routes->post('available/(:num)', 'Certificado::markAvailable/$1');
    $routes->get('import', 'Certificado::import');
    $routes->post('import', 'Certificado::import');
});

$routes->group('', ['filter' => 'auth:certconfig.manage'], static function ($routes) {
    $routes->get('/certconfig', 'CertConfig::index');
    $routes->get('/certconfig/create', 'CertConfig::create');
    $routes->post('/certconfig/store', 'CertConfig::store');
    $routes->get('/certconfig/edit/(:num)', 'CertConfig::edit/$1');
    $routes->get('/certconfig/copy/(:num)', 'CertConfig::copy/$1');
    $routes->post('/certconfig/delete/(:num)', 'CertConfig::delete/$1');
    $routes->post('/certconfig/preview', 'CertConfig::preview');
    $routes->post('/certconfig/upload-image', 'CertConfig::uploadImage');

    $routes->get('/lista_concursos', 'CertConfig::index');
    $routes->get('/edita_concurso/(:num)', 'CertConfig::edit/$1');
    $routes->post('/update_concurso', 'CertConfig::storeLegacy');
    $routes->post('/insert_concurso', 'CertConfig::storeLegacy');
    $routes->get('/new_concurso', 'CertConfig::create');
});

$routes->group('', ['filter' => 'auth:clube.manage'], static function ($routes) {
    $routes->get('/clubes', 'Clube::index');
    $routes->get('/clube', 'Clube::index');
    $routes->get('/clube/create', 'Clube::create');
    $routes->post('/clube/store', 'Clube::store');
    $routes->get('/clube/edit/(:num)', 'Clube::edit/$1');
    $routes->post('/clube/delete/(:num)', 'Clube::delete/$1');
    $routes->get('/edita_clube/(:num)', 'Clube::edit/$1');
});
//$routes->get('/store/(:any)', )




//submit_concurso


// app/Config/Routes.php

//$routes->group('auth', function ($routes) {
//    $routes->get('login', 'Auth::showLogin');
//    $routes->post('login', 'Auth::processLogin');
//    $routes->get('logout', 'Auth::logout');
//});

//$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
//    $routes->get('/', 'Dashboard::index');
//});



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

 
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
