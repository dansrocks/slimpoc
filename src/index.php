<?php

use Dansrocks\Slimpoc\Action\WelcomeAction;
use Dansrocks\Slimpoc\Service\Configuration;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;
use Psr\Container\ContainerInterface;
use UMA\DIC\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container(require __DIR__ . '/settings.php');

AppFactory::setContainer($container);
$app = AppFactory::create();

$container = $app->getContainer();
$container->set('configuration', function (ContainerInterface $c) {
    return new Configuration($c->get('appName'));
});

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
