<?php

declare(strict_types=1);

namespace TaskManager\Application\Dto;

use TaskManager\Domain\Entity\Task;

final class TaskDto
{
    private string $id;

    private string $title;

    private string $dueDate;

    private string $status;

    private ?string $description;

    /**
     * @param Task $task
     * @return TaskDto
     */
    public static function fromTask(Task $task): self
    {
        return new self(
            (string) $task->getId(),
            $task->getTitle(),
            (string) $task->getDueDate(),
            (string) $task->getStatus(),
            $task->getDescription()
        );
    }

    /**
     * @param string      $id
     * @param string      $title
     * @param string      $dueDate
     * @param string      $status
     * @param string|null $description
     */
    public function __construct(string $id, string $title, string $dueDate, string $status, ?string $description)
    {
        $this->id          = $id;
        $this->title       = $title;
        $this->dueDate     = $dueDate;
        $this->status      = $status;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
