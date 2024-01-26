<?php

use Dansrocks\Slimpoc\Action\WelcomeAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
$cachePath = realpath(__DIR__ . '/../cache/');
if (file_exists($cachePath) && is_dir($cachePath) && is_writable($cachePath)) {
    $routeCollector = $app->getRouteCollector();
    $routeCollector->setCacheFile($cachePath . '/routes.cache');
}

$app->get('/', WelcomeAction::class)->setName('bienvenido');

$app->group('/books', function (\Slim\Routing\RouteCollectorProxy $group) {

    $group->get('[/]', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $response->getBody()->write("List books");
        return $response;
    })->setName('books-list');

    $group->get('/search', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $response->getBody()->write("Search a book");
        return $response;
    })->setName('book-search');

    $group->get('/show', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $response->getBody()->write("Show a book");
        return $response;
    })->setName('book-show');

});

$app->get('/{name}', WelcomeAction::class)->setName('bienvenido-fulanito');

$app->run();
