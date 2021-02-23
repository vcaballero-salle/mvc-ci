<?php
declare(strict_types=1);

namespace SallePW\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SallePW\Model\Task;
use SallePW\Model\UseCase\ListTasksUseCase;
use Slim\Views\Twig;

class ListTasksController
{
    private const KEY_TITLE = "title";
    private const KEY_CONTENT = "content";
    private const KEY_CREATED_AT = "created_at";

    private ListTasksUseCase $listTasksUseCase;

    private Twig $twig;

    public function __construct(ListTasksUseCase $listTasksUseCase, Twig $twig)
    {
        $this->listTasksUseCase = $listTasksUseCase;
        $this->twig = $twig;
    }

    public function apply(RequestInterface $request, ResponseInterface $response)
    {
        $tasks = $this->listTasksUseCase->apply();

        $tasksInAssociativeArray = array_map(function (Task $task) {
            return $this->taskToAssociativeArray($task);
        }, $tasks);

        return $this->twig->render($response, 'list_tasks.twig', ["tasks" => $tasksInAssociativeArray]);
    }

    private function taskToAssociativeArray(Task $task) {
        return [
            self::KEY_TITLE => $task->title(),
            self::KEY_CONTENT => $task->content(),
            self::KEY_CREATED_AT => $task->createdAt()->format('Y-m-d H:i:s')
        ];
    }
}