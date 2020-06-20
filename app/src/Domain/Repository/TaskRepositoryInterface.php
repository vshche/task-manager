<?php

declare(strict_types=1);

namespace TaskManager\Domain\Repository;

use TaskManager\Domain\Entity\Task;
use TaskManager\Domain\Exception\TaskNotFoundException;
use TaskManager\Domain\ValueObject\TaskId;
use TaskManager\Domain\ValueObject\TaskStatus;

interface TaskRepositoryInterface
{
    /**
     * @return Task[]
     */
    public function getAll(): iterable;

    /**
     * @param TaskId $id
     * @return Task
     * @throws TaskNotFoundException
     */
    public function getById(TaskId $id): Task;

    /**
     * @param TaskStatus|null $status
     * @return Task[]
     */
    public function search(TaskStatus $status = null): iterable;

    /**
     * @param Task $task
     */
    public function save(Task $task): void;

    /**
     * @param Task $task
     */
    public function remove(Task $task): void;
}
