<?php
declare(strict_types=1);

use SallePW\Controller\CreateTaskController;
use SallePW\Controller\CreateTaskFormGuiController;
use Slim\App;

function addRoutes(App $app): void {
    $app->get('/task/add', CreateTaskFormGuiController::class . ":getFormAction");
    $app->post('/task', CreateTaskController::class . ":apply");
}