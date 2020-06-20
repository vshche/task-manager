<?php

declare(strict_types=1);

namespace TaskManager\Application\Command\UpdateTask;

use Symfony\Component\Validator\Constraints as Assert;
use TaskManager\Domain\ValueObject\TaskId;

/**
 * @see StartTaskCommandHandler
 */
final class StartTaskCommand
{
    /**
     * @Assert\NotBlank()
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
