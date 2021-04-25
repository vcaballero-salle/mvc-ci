<?php

namespace SallePW\Model;

use DateTime;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testCanCreateATask()
    {
        $now = new DateTime();
        $task = new Task(1, "test", "content", $now, $now);
        self::assertIsInt($task->id());
        self::assertEquals("content", $task->content());
        self::assertEquals("test", $task->title());
        self::assertEquals($now, $task->createdAt());
        self::assertEquals($now, $task->updatedAt());
    }

}