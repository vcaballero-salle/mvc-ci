<?php
declare(strict_types=1);

namespace SallePW\Repository;

use PDO;
use SallePW\Model\Repository\TaskRepository;
use SallePW\Model\Task;

class MysqlTaskRepository implements TaskRepository
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private PDOSingleton $database;

    public function __construct(PDOSingleton $database)
    {
        $this->database = $database;
    }

    public function save(Task $task): void
    {
        $query = <<<QUERY
        INSERT INTO task(title, content, created_at, updated_at)
        VALUES(:title, :content, :created_at, :updated_at)
QUERY;
        $statement = $this->database->connection()->prepare($query);

        $title = $task->title();
        $content = $task->content();
        $createdAt = $task->createdAt()->format(self::DATE_FORMAT);
        $updatedAt = $task->updatedAt()->format(self::DATE_FORMAT);

        $statement->bindParam('title', $title, PDO::PARAM_STR);
        $statement->bindParam('content', $content, PDO::PARAM_STR);
        $statement->bindParam('created_at', $createdAt, PDO::PARAM_STR);
        $statement->bindParam('updated_at', $updatedAt, PDO::PARAM_STR);

        $statement->execute();
    }
}