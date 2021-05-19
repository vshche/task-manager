<?php

declare(strict_types=1);

namespace TaskManager\Application\Command\CreateTask;

use Ramsey\Uuid\Uuid;
use TaskManager\Application\CommandHandlerInterface;
use TaskManager\Application\Dto\TaskDto;
use TaskManager\Domain\Entity\Task;
use TaskManager\Domain\Repository\TaskRepositoryInterface;
use TaskManager\Domain\ValueObject\TaskId;

class CreateTaskCommandHandler implements CommandHandlerInterface
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
     * @param CreateTaskCommand $command
     * @return TaskDto
     */
    public function __invoke(CreateTaskCommand $command): TaskDto
    {
        $taskId = new TaskId((string) Uuid::uuid4());

        $task = new Task(
            $taskId,
            $command->getTitle(),
            $command->getDueDate(),
            $command->getDescription()
        );

        $this->taskRepository->save($task);

        return TaskDto::fromTask($task);
    }
}
