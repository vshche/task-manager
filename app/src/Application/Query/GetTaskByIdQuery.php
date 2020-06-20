<?php

declare(strict_types=1);

namespace TaskManager\Application\Query;

use TaskManager\Domain\ValueObject\TaskId;

/**
 * @see GetTaskByIdQueryHandler
 */
final class GetTaskByIdQuery
{
    /**
     * @var TaskId|null
     */
    private ?TaskId $id;

    /**
     * @param TaskId|null $id
     */
    public function __construct(TaskId $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return TaskId|null
     */
    public function getId(): ?TaskId
    {
        return $this->id;
    }

    /**
     * @param TaskId|null $id
     * @return self
     */
    public function setId(?TaskId $id): self
    {
        $this->id = $id;
        return $this;
    }
}
