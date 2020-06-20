<?php

declare(strict_types=1);

namespace TaskManager\Application\Query;

use TaskManager\Application\Dto\TaskDto;
use TaskManager\Application\QueryHandlerInterface;
use TaskManager\Domain\Exception\TaskNotFoundException;
use TaskManager\Domain\Repository\TaskRepositoryInterface;

class GetTaskByIdQueryHandler implements QueryHandlerInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private TaskRepositoryInterface $taskRepository;

    /**
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param GetTaskByIdQuery $query
     * @return TaskDto
     * @throws TaskNotFoundException
     */
    public function __invoke(GetTaskByIdQuery $query): TaskDto
    {
        return TaskDto::fromTask($this->taskRepository->getById($query->getId()));
    }
}
