<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function($routes){
    $routes->resource('pasien', ['filter' => 'auth']);
});

$routes->group('user/v1', function($routes){
    $routes->post('register', 'UserController::register');
    $routes->post('login', 'UserController::login');
    $routes->get('profile/(:num)', 'UserController::getProfile/$1', ['filter' => 'auth']);
});

$routes->group('email/v1', function($routes){
    $routes->post('send', 'SendEmail::index');
});

