<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Bus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use TaskManager\Application\QueryBusInterface;

class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $queryMessageBus
     */
    public function __construct(MessageBusInterface $queryMessageBus)
    {
        $this->messageBus = $queryMessageBus;
    }

    /**
     * @param object $query
     *
     * @return mixed The handler returned value
     */
    public function query(object $query)
    {
        return $this->handle($query);
    }
}
