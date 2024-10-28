<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// User Routes
$routes->group('users', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'UserController::index');         // Get all users
    $routes->get('(:num)', 'UserController::show/$1');  // Get a single user by ID
    $routes->post('/', 'UserController::create');       // Create a new user
    $routes->put('(:num)', 'UserController::update/$1');// Update an existing user by ID
    $routes->delete('(:num)', 'UserController::delete/$1'); // Delete a user by ID
});

// Order Routes
$routes->group('orders', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'OrderController::index');          // Get all orders
    $routes->get('(:num)', 'OrderController::show/$1');   // Get a single order by ID
    $routes->post('/', 'OrderController::create');        // Create a new order
    $routes->put('(:num)', 'OrderController::update/$1'); // Update an existing order by ID
    $routes->delete('(:num)', 'OrderController::delete/$1'); // Delete an order by ID
});

// Product Routes
$routes->group('products', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'ProductsController::index');           // Get all products
    $routes->get('(:num)', 'ProductsController::show/$1');    // Get a single product by ID
    $routes->post('/', 'ProductsController::create');         // Create a new product
    $routes->put('(:num)', 'ProductsController::update/$1');  // Update an existing product by ID
    $routes->delete('(:num)', 'ProductsController::delete/$1'); // Delete a product by ID
});