<?php

declare(strict_types=1);

namespace TaskManager\Application;

interface CommandBusInterface
{
    /**
     * @param object $command
     * @return mixed
     */
    public function command(object $command);
}
