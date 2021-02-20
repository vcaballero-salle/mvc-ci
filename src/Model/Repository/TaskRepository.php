<?php
declare(strict_types=1);

namespace SallePW\Model\Repository;

use SallePW\Model\Task;

interface TaskRepository
{
    public function save(Task $task): void;
}
