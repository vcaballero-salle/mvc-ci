<?php
declare(strict_types=1);

namespace SallePW\Controller;

use SallePW\Model\Task;
use Slim\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use SallePW\Model\UseCase\CreateTaskUseCase;

class CreateTaskController
{
    private CreateTaskUseCase $createTaskUseCase;

    public function __construct(CreateTaskUseCase $createTaskUseCase)
    {
        $this->createTaskUseCase = $createTaskUseCase;
    }

    public function apply(Request $request, ResponseInterface $response)
    {
        $parsedRequestBody = $request->getParsedBody();

        $title = $parsedRequestBody["title"];
        $content = $parsedRequestBody["content"];

        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $content = filter_var($content, FILTER_SANITIZE_STRING);

        $task = new Task(null, $title, $content, new \DateTime(), new \DateTime());

        $this->createTaskUseCase->apply($task);

        $response = $response->withAddedHeader("Location", "/task")->withStatus(303);

        return $response;

    }
}