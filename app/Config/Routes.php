<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('api', function ($api) {
    $api->group('auth', function ($auth) {
        $auth->post('register', 'Api\AuthController::RegisterController');
        $auth->post('login', 'Api\AuthController::LoginController');
    });
    $api->group('user', ['filter' => 'jwt'],  function ($user) {
        $user->group('users', function ($users) {
            $users->get('/', 'Api\UserController::GetUsersController');
            $users->get('(:segment)', 'Api\UserController::GetUserController/$1');
            $users->post('/', 'Api\UserController::CreateUserController');
            $users->put('(:segment)', 'Api\UserController::UpdateUserController/$1');
            $users->delete('(:segment)', 'Api\UserController::DeleteUserController/$1');
        });
    });
});
