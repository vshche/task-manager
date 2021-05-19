<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use TaskManager\Domain\Entity\Task;
use TaskManager\Domain\Exception\TaskNotFoundException;
use TaskManager\Domain\Repository\TaskRepositoryInterface;
use TaskManager\Domain\ValueObject\TaskId;
use TaskManager\Domain\ValueObject\TaskStatus;

class TaskRepository implements TaskRepositoryInterface
{
    private EntityManagerInterface $em;

    private ObjectRepository $repository;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Task::class);
    }

    /**
     * @inheritDoc
     */
    public function getAll(): iterable
    {
        return $this->repository->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getById(TaskId $id): Task
    {
        $task = $this->repository->find($id);

        if (!$task instanceof Task) {
            throw TaskNotFoundException::byId($id);
        }

        return $task;
    }

    /**
     * @inheritDoc
     */
    public function search(TaskStatus $status = null): iterable
    {
        $criteria = [];

        if ($status !== null) {
            $criteria['status'] = $status;
        }

        return $this->repository->findBy($criteria);
    }

    /**
     * @inheritDoc
     */
    public function save(Task $task): void
    {
        $this->em->persist($task);
    }

    /**
     * @inheritDoc
     */
    public function remove(Task $task): void
    {
        $this->em->remove($task);
    }
}
