<?php
declare(strict_types=1);

namespace SallePW\Model\UseCase;

use DateTime;
use PHPUnit\Framework\TestCase;
use SallePW\Model\Task;
use SallePW\Repository\MysqlTaskRepository;

class ListTasksUseCaseTest extends testCase
{
    public function testListTasks()
    {
        $taskRepository = $this->createMock(MysqlTaskRepository::class);
        $listTasksUseCase = new ListTasksUseCase($taskRepository);

        $expectedTasks = array(
            new Task(1, "one", "content one", new DateTime(), new DateTime()),
            new Task(2, "two", "content two", new DateTime(), new DateTime())
        );

        $taskRepository->method("getAll")
            ->willReturn($expectedTasks);

        $taskRepository->expects($this->once())
            ->method("getAll");

        $actualTasks = $listTasksUseCase->apply();
        $this->assertSame($expectedTasks, $actualTasks, "Result is not the same");
    }
}