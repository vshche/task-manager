<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskManager\Application\Command\CreateTask\CreateTaskCommand;
use TaskManager\Application\Command\UpdateTask\FinishTaskCommand;
use TaskManager\Application\Command\UpdateTask\StartTaskCommand;
use TaskManager\Application\Command\UpdateTask\UpdateTaskCommand;
use TaskManager\Application\CommandBusInterface;
use TaskManager\Application\Dto\TaskDto;
use TaskManager\Application\Query\GetTaskByIdQuery;
use TaskManager\Application\Query\SearchTasksQuery;
use TaskManager\Application\QueryBusInterface;
use TaskManager\Domain\ValueObject\TaskId;

/**
 * @Rest\Route("tasks")
 */
class TaskController
{
    /**
     * @var CommandBusInterface
     */
    private CommandBusInterface $commandBus;

    /**
     * @var QueryBusInterface
     */
    private QueryBusInterface $queryBus;

    /**
     * @param CommandBusInterface $commandBus
     * @param QueryBusInterface   $queryBus
     */
    public function __construct(CommandBusInterface $commandBus, QueryBusInterface $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @param CreateTaskCommand $command
     * @return TaskDto
     *
     * @Rest\Post("")
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     *
     * @ParamConverter("command", converter="fos_rest.request_body")
     */
    public function create(CreateTaskCommand $command): TaskDto
    {
        return $this->commandBus->command($command);
    }

    /**
     * @param UpdateTaskCommand $command
     * @param string            $id
     * @return TaskDto
     *
     * @Rest\Put("/{id}", requirements={"id"="[\w-]+"})
     *
     * @ParamConverter("command", converter="fos_rest.request_body")
     */
    public function update(UpdateTaskCommand $command, string $id): TaskDto
    {
        return $this->commandBus->command($command->setId(TaskId::fromString($id)));
    }

    /**
     * @param string $id
     * @return TaskDto
     *
     * @Rest\Post("/{id}/start", requirements={"id"="[\w-]+"})
     */
    public function startProgress(string $id): TaskDto
    {
        return $this->commandBus->command(new StartTaskCommand(TaskId::fromString($id)));
    }

    /**
     * @param string $id
     * @return TaskDto
     *
     * @Rest\Post("/{id}/finish", requirements={"id"="[\w-]+"})
     */
    public function finishProgress(string $id): TaskDto
    {
        return $this->commandBus->command(new FinishTaskCommand(TaskId::fromString($id)));
    }

    /**
     * @param string $id
     * @return TaskDto
     *
     * @Rest\Get("/{id}", requirements={"id"="[\w-]+"})
     */
    public function get(string $id): TaskDto
    {
        return $this->queryBus->query(new GetTaskByIdQuery(TaskId::fromString($id)));
    }

    /**
     * @param Request $request
     * @return TaskDto[]
     *
     * @Rest\Get("")
     */
    public function search(Request $request): iterable
    {
        return $this->queryBus->query(SearchTasksQuery::fromArray($request->query->all()));
    }
}
