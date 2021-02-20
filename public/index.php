<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use SallePW\ErrorHandler\HttpErrorHandler;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

$container = new Container();

require_once __DIR__ . '/../config/dependencies.php';

addDependencies($container);

AppFactory::setContainer($container);

$app = AppFactory::create();

$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$app->add(TwigMiddleware::createFromContainer($app));

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, false, false);

$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

require_once __DIR__ . '/../config/routing.php';

addRoutes($app);

$app->run();