<?php

declare(strict_types=1);

namespace TaskManager\Domain\Event\Task;

use TaskManager\Domain\Entity\Task;

final class TaskUpdatedEvent
{
    private Task $original;

    private Task $updated;

    /**
     * @param Task $original
     * @param Task $updated
     */
    public function __construct(Task $original, Task $updated)
    {

        $this->original = $original;
        $this->updated = $updated;
    }

    /**
     * @return Task
     */
    public function getOriginal(): Task
    {
        return $this->original;
    }

    /**
     * @return Task
     */
    public function getUpdated(): Task
    {
        return $this->updated;
    }
}
