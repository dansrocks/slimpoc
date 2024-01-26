<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
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

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
})->setName('bienvenido');

$app->get('/{name}', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello ${args['name']}!");
    return $response;
})->setName('bienvenido-fulanito');

$app->run();
