<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\NotFoundException;



require __DIR__ . '/../vendor/autoload.php';

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
