<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;
use SallePW\Controller\CreateTaskController;
use SallePW\Model\Repository\TaskRepository;
use SallePW\Model\UseCase\CreateTaskUseCase;
use SallePW\Repository\MysqlTaskRepository;
use SallePW\Repository\PDOSingleton;
use Slim\Views\Twig;
use SallePW\Controller\CreateTaskFormGuiController;

function addDependencies(ContainerInterface $container): void {
    $container->set(
        "view",
        function () {
            return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
        }
    );

    $container->set(
        "db",
        function () {
            $pdoSingleton = PDOSingleton::getInstance(
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_ROOT_PASSWORD'],
                $_ENV['MYSQL_HOST'],
                $_ENV['MYSQL_PORT'],
                $_ENV['MYSQL_DATABASE']);

            return $pdoSingleton;
        }
    );

    $container->set(TaskRepository::class, function (ContainerInterface $container) {
        return new MysqlTaskRepository($container->get('db'));
    });

    $container->set(
        CreateTaskFormGuiController::class,
        function (ContainerInterface $c) {
            $controller = new CreateTaskFormGuiController($c->get("view"));
            return $controller;
        }
    );


    $container->set(
        CreateTaskUseCase::class,
        function (ContainerInterface $c) {
            $createTaskUseCase = new CreateTaskUseCase($c->get(TaskRepository::class));
            return $createTaskUseCase;
        }
    );

    $container->set(
        CreateTaskController::class,
        function (ContainerInterface $c) {
            $controller = new CreateTaskController($c->get(CreateTaskUseCase::class));
            return $controller;
        }
    );
}