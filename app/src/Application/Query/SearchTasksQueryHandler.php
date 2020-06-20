<?php

declare(strict_types=1);

namespace TaskManager\Application\Query;

use TaskManager\Application\Dto\TaskDto;
use TaskManager\Application\QueryHandlerInterface;
use TaskManager\Domain\Entity\Task;
use TaskManager\Domain\Repository\TaskRepositoryInterface;
use TaskManager\Domain\ValueObject\TaskStatus;

class SearchTasksQueryHandler implements QueryHandlerInterface
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
     * @param SearchTasksQuery $query
     * @return TaskDto[]
     */
    public function __invoke(SearchTasksQuery $query): iterable
    {
        $status = null;
        if ($query->getStatus() !== null) {
            $status = new TaskStatus($query->getStatus());
        }

        return array_map(
            fn(Task $task) => TaskDto::fromTask($task),
            $this->taskRepository->search($status)
        );
    }
}
