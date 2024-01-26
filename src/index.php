<?php

use Dansrocks\Slimpoc\Action\WelcomeAction;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Psr\Log\LogLevel;


require __DIR__ . '/../vendor/autoload.php';


$containerBuilder = new ContainerBuilder();

// configure PHP-DI here
$containerBuilder->addDefinitions([
    'settings' => [
        'displayErrorDetails' => true, // Should be set to false in production
        'logger' => [
            'name' => 'SlimPoC',
            'path' => 'php://stderr',
            'level' => LogLevel::DEBUG,
        ],
    ],
]);

AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

// enable cache for routing
$routeCachePath = realpath(__DIR__ . '/../cache/');
$routeCollector = $app->getRouteCollector();
$routeCollector->setCacheFile($routeCachePath . '/routes.cache');

$app->get('/', WelcomeAction::class)->setName('bienvenido');
$app->get('/{name}', WelcomeAction::class)->setName('bienvenido-fulanito');

$app->run();
