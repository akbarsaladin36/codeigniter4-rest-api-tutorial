<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('api', function ($api) {
    $api->group('users', function ($users) {
        $users->get('/', 'Api\UserController::GetUsersController');
        $users->get('(:segment)', 'Api\UserController::GetUserController/$1');
        $users->post('/', 'Api\UserController::CreateUserController');
        $users->put('(:segment)', 'Api\UserController::UpdateUserController/$1');
        $users->delete('(:segment)', 'Api\UserController::DeleteUserController/$1');
    });
});
