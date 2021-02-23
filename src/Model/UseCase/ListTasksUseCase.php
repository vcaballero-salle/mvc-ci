<?php
declare(strict_types=1);

namespace SallePW\Model\UseCase;

use SallePW\Model\Repository\TaskRepository;
use SallePW\Model\Task;

final class ListTasksUseCase
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function apply(): array
    {
        return $this->repository->getAll();
    }
}
