<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Bus;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use TaskManager\Application\CommandBusInterface;

class CommandBus implements CommandBusInterface
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $commandMessageBus
     */
    public function __construct(MessageBusInterface $commandMessageBus)
    {
        $this->messageBus = $commandMessageBus;
    }

    /**
     * @param object $command
     *
     * @return mixed The handler returned value
     */
    public function command(object $command)
    {
        return $this->handle($command);
    }
}
