<?php

namespace Dansrocks\Slimpoc\Action;

use Dansrocks\Slimpoc\Service\Configuration;
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

        /** @var Configuration $service */
        $service = $this->container->get('configuration');

        $host = $service->getHost();
        $appName =  $service->getAppName();

        $response->getBody()->write("<pre>\n");
        $response->getBody()->write(sprintf("Hola, %s!\n", $name));
        $response->getBody()->write(sprintf("Host: %s\n", $host));
        $response->getBody()->write(sprintf("AppName: %s\n",$appName));
        $response->getBody()->write("</pre>\n");

        return $response;
    }
}