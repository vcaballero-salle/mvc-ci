<?php
declare(strict_types=1);

namespace SallePW\Model\UseCase;

use DateTime;
use PHPUnit\Framework\TestCase;
use SallePW\Model\Task;
use SallePW\Repository\MysqlTaskRepository;

class CreateTaskUseCaseTest extends TestCase
{
    public function testCreateTask()
    {
        $task = new Task(1, "test", "test", new DateTime(), new DateTime());

        $taskRepository = $this->createMock(MysqlTaskRepository::class);
        $createTaskUseCase = new CreateTaskUseCase($taskRepository);

        $taskRepository->expects($this->once())
            ->method("save")
            ->with($this->equalTo($task));

        $createTaskUseCase->apply($task);
    }

}