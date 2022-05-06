<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('Catalog\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Common\Home::index', ['as' => 'home']);

// Information
$routes->add('{locale}/contact-us', 'Information\Contact::index', ['as' => 'contact_us']);
$routes->add('{locale}/i/(:any)', 'Information\Information::index/$1', ['as' => 'information']);

// Category
$routes->add('{locale}/category/(:alphanum)', 'Catalog\Category::index/$1', ['as' => 'category']);

// Account
$routes->group('{locale}/account', function($routes)
{
	$routes->add('login', 'Account/Login::index', ['as' => 'account_login']);
    $routes->add('register', 'Account/Register::index', ['as' => 'account_register']);
	$routes->add('dashboard', 'Account/Dashboard::index/$1', ['as' => 'account_dashboard']);
	$routes->add('success', 'Account/Success::index/$1', ['as' => 'account_success']);
	$routes->add('logout', 'Account/Logout::index', ['as' => 'account_logout']);

});

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
