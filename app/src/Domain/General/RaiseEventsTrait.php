<?php

declare(strict_types=1);

namespace TaskManager\Domain\General;

trait RaiseEventsTrait
{
    /**
     * @var object[]
     */
    protected array $events = [];

    /**
     * @return object[]
     */
    public function popEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }

    /**
     * @param object $event
     */
    public function raise(object $event): void
    {
        $this->events[] = $event;
    }
}
