<?php

declare(strict_types=1);

namespace TaskManager\Application\Command\UpdateTask;

use TaskManager\Application\CommandHandlerInterface;
use TaskManager\Application\Dto\TaskDto;
use TaskManager\Domain\Repository\TaskRepositoryInterface;

class UpdateTaskCommandHandler implements CommandHandlerInterface
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
     * @param UpdateTaskCommand $command
     * @return TaskDto
     */
    public function __invoke(UpdateTaskCommand $command): TaskDto
    {
        $task = $this->taskRepository->getById($command->getId());

        $task->update($command->getTitle(), $command->getDueDate(), $command->getDescription());

        $this->taskRepository->save($task);

        return TaskDto::fromTask($task);
    }
}
