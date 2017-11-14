<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

//Config option Slim
$appConf = require_once __DIR__ . '/../etc/app-conf.php';


// instantiate the App object
$app = new Slim\App($appConf);


App\Models\Driver\Engine::setConnection('framework', $appConf['dbConfig']['main']);

// Get container
$container = $app->getContainer();

//Twig
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [

        'cache' => false,
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->getEnvironment()->addGlobal("current_path", $container["request"]->getUri()->getPath());
    return $view;

};

$container['validator'] = function ($container) {

    return new App\Validation\Validator;
};



// Add route
require __DIR__ . '/../app/routes.php';


// Run application
$app->run();






