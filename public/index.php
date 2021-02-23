<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use SallePW\ErrorHandler\HttpErrorHandler;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();

$dotenv->load(__DIR__ . '/../.env');

$container = new Container();

require_once __DIR__ . '/../config/dependencies.php';

addDependencies($container);

AppFactory::setContainer($container);

$app = AppFactory::create();

$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$app->addBodyParsingMiddleware();

$app->add(TwigMiddleware::createFromContainer($app));

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, false, false);

$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

require_once __DIR__ . '/../config/routing.php';

addRoutes($app);

$app->run();