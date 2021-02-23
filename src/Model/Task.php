<?php
declare(strict_types=1);

namespace SallePW\Model;

use DateTime;

final class Task
{
    private ?int $id;
    private string $title;
    private string $content;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(?int $id, string $title, string $content, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}