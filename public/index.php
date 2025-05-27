<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Factory\AppFactory;
//add dependency injection container
use DI\Container;



require __DIR__ . '/../vendor/autoload.php';
// Create a new DI container
$container = new Container();
AppFactory::setContainer($container);

// Add any dependencies to the container here
$container->set('view', function(){
    return Twig::create(__DIR__ . '/../templates', [
        'cache' => false, // Set to true in production
    ]);
});



$app = AppFactory::create();
$app->add(TwigMiddleware::createFromContainer($app));

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello, World!");
    return $response;
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {

    return $this->get('view')->render($response, 'hello.html', [
        'name' => $args['name']
    ]);
});

$app->run();