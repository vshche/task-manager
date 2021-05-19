<?php

declare(strict_types=1);

namespace TaskManager\Application\Command\CreateTask;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var DateTimeInterface|null
     *
     * @Assert\NotBlank()
     */
    private ?DateTimeInterface $dueDate;

    /**
     * @param string|null            $title
     * @param string|null            $description
     * @param DateTimeInterface|null $dueDate
     */
    public function __construct(string $title = null, string $description = null, DateTimeInterface $dueDate = null)
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
     * @return DateTimeInterface|null
     */
    public function getDueDate(): ?DateTimeInterface
    {
        return $this->dueDate;
    }

    /**
     * @param DateTimeInterface|null $dueDate
     * @return CreateTaskCommand
     */
    public function setDueDate(?DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;
        return $this;
    }
}
