<?php

declare(strict_types=1);

namespace TaskManager\Application\Command\UpdateTask;

use Symfony\Component\Validator\Constraints as Assert;
use TaskManager\Domain\ValueObject\TaskId;
use TaskManager\Domain\ValueObject\DateTime;

/**
 * @see UpdateTaskCommandHandler
 */
final class UpdateTaskCommand
{
    /**
     * @var TaskId|null
     *
     * @Assert\NotBlank()
     */
    private ?TaskId $id;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=64)
     */
    private ?string $title;

    /**
     * @var string|null
     *
     * @Assert\Length(max=1000)
     */
    private ?string $description;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     * @Assert\DateTime(format=DateTime::FORMAT)
     */
    private ?string $dueDate;

    /**
     * @param TaskId|null $id
     * @param string|null $title
     * @param string|null $description
     * @param string|null $dueDate
     */
    public function __construct(TaskId $id = null, string $title = null, string $description = null, string $dueDate = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->dueDate = $dueDate;
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

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return self
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    /**
     * @param string|null $dueDate
     * @return self
     */
    public function setDueDate(?string $dueDate): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }
}
