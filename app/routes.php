<?php

$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};


$container['AuthController'] = function ($container) {
    return new App\Controllers\Auth\AuthController($container);
};


$container['UserController'] = function ($container) {
    return new \App\Controllers\UserController($container);
};

$app->add(new \App\Middleware\ValidationErrorsMiddelware($container));


$app->get('/', 'HomeController:index')->setName('home');
$app->get('/users', 'UserController:index')->setName('users');

$app->get('/users/add', 'UserController:getUserAdd')->setName('users.add');
$app->post('/users/add', 'UserController:postUserAdd');

$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSingUp');
