<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('Admin\Controllers');
$routes->setDefaultController('Common\Login');
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
$routes->get('/', 'Common\Login::index');

// Extenstions Collection
$routes->group('extensions', ['namespace' => 'Extensions\Controllers'], function ($routes) {
    // Analytics
    $routes->get('analytics/google', 'Analytics\Google::index');
    $routes->post('analytics/google/edit', 'Analytics\Google::edit');
    // dashboard
    $routes->get('dashboard/customer_activity', 'Dashboard\Customer_activity::index');
    $routes->post('dashboard/customer_activity/edit', 'Dashboard\Customer_activity::edit');
    $routes->post('dashboard/customer_online/edit', 'Dashboard\Customer_online::edit');
    $routes->get('dashboard/customer_online', 'Dashboard\Customer_online::index');
    // Reports
    $routes->get('report/user_activity', 'Report\User_activity::index');
    $routes->post('report/user_activity/edit', 'Report\User_activity::edit');
    $routes->post('report/user_activity/delete', 'Report\User_activity::delete');
    $routes->get('report/user_activity/report', 'Report\User_activity::report');
    // Themes
    $routes->get('theme/basic', 'Theme\Basic::index');
    $routes->post('theme/basic/edit', 'Theme\Basic::edit');
    // Blog
    $routes->get('blog/category', 'Blog\Category::index');
    $routes->get('blog/category/form', 'Blog\Category::form');
    $routes->post('blog/category/add', 'Blog\Category::add');
    $routes->post('blog/category/edit', 'Blog\Category::edit');
    $routes->post('blog/category/delete', 'Blog\Category::delete');

    $routes->get('blog/post', 'Blog\Post::index');
    $routes->get('blog/post/form', 'Blog\post::form');
    $routes->post('blog/post/add', 'Blog\post::add');
    $routes->post('blog/post/edit', 'Blog\post::edit');
    $routes->post('blog/post/delete', 'Blog\post::delete');

    $routes->get('blog/comment', 'Blog\Comment::index');
    $routes->get('blog/comment/form', 'Blog\comment::form');
    $routes->post('blog/comment/add', 'Blog\comment::add');
    $routes->post('blog/comment/edit', 'Blog\comment::edit');
    $routes->post('blog/comment/delete', 'Blog\comment::delete');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
