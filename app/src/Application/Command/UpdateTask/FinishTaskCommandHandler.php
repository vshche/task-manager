<?php

declare(strict_types=1);

namespace TaskManager\Application\Command\UpdateTask;

use TaskManager\Application\CommandHandlerInterface;
use TaskManager\Application\Dto\TaskDto;
use TaskManager\Domain\Repository\TaskRepositoryInterface;

class FinishTaskCommandHandler implements CommandHandlerInterface
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
     * @param FinishTaskCommand $command
     * @return TaskDto
     */
    public function __invoke(FinishTaskCommand $command): TaskDto
    {
        $task = $this->taskRepository->getById($command->getId());

        $task->finish();

        $this->taskRepository->save($task);

        return TaskDto::fromTask($task);
    }
}
