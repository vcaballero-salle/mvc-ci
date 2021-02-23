<?php
declare(strict_types=1);

namespace SallePW\Repository;

use PDO;
use SallePW\Model\Repository\TaskRepository;
use SallePW\Model\Task;

class MysqlTaskRepository implements TaskRepository
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private const KEY_ID = "id";
    private const KEY_TITLE = "title";
    private const KEY_CONTENT = "content";
    private const KEY_CREATED_AT = "created_at";
    private const KEY_UPDATED_AT = "updated_at";

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

        $statement->bindParam(self::KEY_TITLE, $title, PDO::PARAM_STR);
        $statement->bindParam(self::KEY_CONTENT, $content, PDO::PARAM_STR);
        $statement->bindParam(self::KEY_CREATED_AT, $createdAt, PDO::PARAM_STR);
        $statement->bindParam(self::KEY_UPDATED_AT, $updatedAt, PDO::PARAM_STR);

        $statement->execute();
    }

    public function getAll(): array
    {
        $query = <<<QUERY
        SELECT * FROM task
QUERY;
        $statement = $this->database->connection()->query($query);

        $tasksInAssociativeArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        $tasks = array_map(function (array $taskAsAssociativeArray) {
            return $this->arrayToTask($taskAsAssociativeArray);
        }, $tasksInAssociativeArray);

        return $tasks;
    }

    private function arrayToTask(array $taskAsAssociativeArray): Task {
        return new Task((int) $taskAsAssociativeArray[self::KEY_ID],
            $taskAsAssociativeArray[self::KEY_TITLE],
            $taskAsAssociativeArray[self::KEY_CONTENT],
            \DateTime::createFromFormat(self::DATE_FORMAT, $taskAsAssociativeArray[self::KEY_CREATED_AT]),
            \DateTime::createFromFormat(self::DATE_FORMAT, $taskAsAssociativeArray[self::KEY_UPDATED_AT]));
    }

}