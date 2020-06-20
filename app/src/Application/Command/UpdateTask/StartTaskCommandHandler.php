<?php

declare(strict_types=1);

namespace TaskManager\Application\Command\UpdateTask;

use TaskManager\Application\CommandHandlerInterface;
use TaskManager\Application\Dto\TaskDto;
use TaskManager\Domain\Repository\TaskRepositoryInterface;

class StartTaskCommandHandler implements CommandHandlerInterface
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
     * @param StartTaskCommand $command
     * @return TaskDto
     */
    public function __invoke(StartTaskCommand $command): TaskDto
    {
        $task = $this->taskRepository->getById($command->getId());

        $task->start();

        $this->taskRepository->save($task);

        return TaskDto::fromTask($task);
    }
}
