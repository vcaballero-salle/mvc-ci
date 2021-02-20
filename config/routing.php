<?php
declare(strict_types=1);

use SallePW\Controller\CreateTaskFormGuiController;
use Slim\App;

function addRoutes(App $app): void {
    $app->get('/task', CreateTaskFormGuiController::class . ":getFormAction");
}