<?php
declare(strict_types=1);

namespace SallePW\Model\UseCase;

use SallePW\Model\Task;
use SallePW\Model\Repository\TaskRepository;

final class CreateTaskUseCase
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function apply(Task $task): void
    {
        $this->repository->save($task);
    }
}
