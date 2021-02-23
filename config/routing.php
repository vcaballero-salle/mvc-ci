<?php
declare(strict_types=1);

use SallePW\Controller\CreateTaskController;
use SallePW\Controller\CreateTaskFormGuiController;
use SallePW\Controller\ListTasksController;
use Slim\App;

function addRoutes(App $app): void {
    $app->get('/task/add', CreateTaskFormGuiController::class . ":apply");
    $app->post('/task', CreateTaskController::class . ":apply");
    $app->get('/task', ListTasksController::class . ":apply");

}