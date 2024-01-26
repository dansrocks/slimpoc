<?php

namespace Dansrocks\Slimpoc\Action;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WelcomeAction
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $name = array_key_exists('name', $args)
            ? $args['name']
            : 'Mundo';

        $response->getBody()->write(sprintf("Hola, %s!\n", $name));

        return $response;
    }
}