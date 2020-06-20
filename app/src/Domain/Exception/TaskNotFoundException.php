<?php

declare(strict_types=1);

namespace TaskManager\Domain\Exception;

use Exception;
use TaskManager\Domain\ValueObject\TaskId;

final class TaskNotFoundException extends Exception
{
    /**
     * @param TaskId $id
     * @return self
     */
    public static function byId(TaskId $id): self
    {
        return new self(sprintf('Task #%s was not found', $id));
    }
}
