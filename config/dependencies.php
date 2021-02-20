<?php
declare(strict_types=1);

use DI\Container;
use Slim\Views\Twig;
use SallePW\Controller\CreateTaskFormGuiController;

function addDependencies(Container $container): void {
    $container->set(
        'view',
        function () {
            return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
        }
    );

    $container->set(
        CreateTaskFormGuiController::class,
        function (Container $c) {
            $controller = new CreateTaskFormGuiController($c->get('view'));
            return $controller;
        }
    );
}