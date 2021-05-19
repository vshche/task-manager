<?php

declare(strict_types=1);

namespace TaskManager\Domain\Entity;

use DateTimeInterface;
use DomainException;
use TaskManager\Domain\Event\Task\TaskCreatedEvent;
use TaskManager\Domain\Event\Task\TaskFinishedEvent;
use TaskManager\Domain\Event\Task\TaskStartedEvent;
use TaskManager\Domain\Event\Task\TaskUpdatedEvent;
use TaskManager\Domain\General\RaiseEventsInterface;
use TaskManager\Domain\General\RaiseEventsTrait;
use TaskManager\Domain\ValueObject\TaskId;
use TaskManager\Domain\ValueObject\TaskStatus;

class Task implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    private TaskId $id;

    private string $title;

    private DateTimeInterface $dueDate;

    private TaskStatus $status;

    private ?string $description;

    /**
     * @param TaskId            $id
     * @param string            $title
     * @param DateTimeInterface $dueDate
     * @param string|null       $description
     */
    public function __construct(
        TaskId $id,
        string $title,
        DateTimeInterface $dueDate,
        string $description = null
    ) {
        $this->id      = $id;
        $this->title   = $title;
        $this->dueDate = $dueDate;
        $this->status  = TaskStatus::createTodo();
        $this->description = $description;

        $this->raise(new TaskCreatedEvent($this));
    }

    /**
     * Change task
     *
     * @param string      $title
     * @param DateTimeInterface    $dueDate
     * @param string|null $description
     */
    public function update(string $title, DateTimeInterface $dueDate, ?string $description): void
    {
        $original = clone $this;

        $this->title = $title;
        $this->dueDate = $dueDate;
        $this->description = $description;

        $this->raise(new TaskUpdatedEvent($original, $this));
    }

    /**
     * Start working on the task
     */
    public function start(): void
    {
        if (!$this->status->isTodo()) {
            throw new DomainException(
                sprintf('Unable to start task, TODO status is expected, but current is %s', $this->status)
            );
        }

        $this->status = TaskStatus::createInProgress();

        $this->raise(new TaskStartedEvent($this));
    }

    /**
     * Finish the task
     */
    public function finish(): void
    {
        if (!$this->status->isInProgress()) {
            throw new DomainException(
                sprintf('Unable to finish task, IN PROGRESS status is expected, but current is %s', $this->status)
            );
        }

        $this->status = TaskStatus::createDone();

        $this->raise(new TaskFinishedEvent($this));
    }

    /**
     * @return TaskId
     */
    public function getId(): TaskId
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
     * @return DateTimeInterface
     */
    public function getDueDate(): DateTimeInterface
    {
        return $this->dueDate;
    }

    /**
     * @return TaskStatus
     */
    public function getStatus(): TaskStatus
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
