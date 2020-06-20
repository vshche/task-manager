<?php

declare(strict_types=1);

namespace TaskManager\Application\Command\CreateTask;

use Symfony\Component\Validator\Constraints as Assert;
use TaskManager\Domain\ValueObject\DateTime;

/**
 * @see CreateTaskCommandHandler
 */
final class CreateTaskCommand
{
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
     * @param string|null   $title
     * @param string|null   $description
     * @param string|null $dueDate
     */
    public function __construct(string $title = null, string $description = null, string $dueDate = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->dueDate = $dueDate;
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
     * @return CreateTaskCommand
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
     * @return CreateTaskCommand
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
     * @return CreateTaskCommand
     */
    public function setDueDate(?string $dueDate): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }
}
