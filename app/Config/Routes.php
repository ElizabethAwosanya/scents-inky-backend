<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/products', 'ProductsController::index');
$routes->get('/products/(:num)', 'ProductsController::show/$1');
$routes->post('/products', 'ProductsController::create');
$routes->put('/products/(:num)', 'ProductsController::update/$1');
$routes->delete('/products/(:num)', 'ProductsController::delete/$1');
