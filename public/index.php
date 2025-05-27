<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
//add dependency injection container
use DI\Container;



require __DIR__ . '/../vendor/autoload.php';
// Create a new DI container
$container = new Container();

// Set the container to be used by the app
AppFactory::setContainer($container);

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, World!");
    return $response;
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = ucfirst($args['name']);
    $response->getBody()->write(sprintf("Hello, %s!", htmlspecialchars($name)));
    return $response;
});

$app->run();