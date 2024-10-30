<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {
    $routes->get('products', 'ProductsController::index');
    $routes->get('products/(:num)', 'ProductsController::show/$1');
    $routes->post('products', 'ProductsController::create');
    $routes->post('products/(:num)', 'ProductsController::update/$1');
    $routes->delete('products/(:num)', 'ProductsController::delete/$1');
    $routes->options('products', 'ProductsController::optionsHandler');
    $routes->options('products/(:any)', 'ProductsController::optionsHandler');

    $routes->post('test-upload', 'ProductsController::testUpload');


});
