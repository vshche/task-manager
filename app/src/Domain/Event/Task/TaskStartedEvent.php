<?php

declare(strict_types=1);

namespace TaskManager\Domain\Event\Task;

use TaskManager\Domain\Entity\Task;

final class TaskStartedEvent
{
    private Task $task;

    /**
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }
}
