<?php

declare(strict_types=1);

namespace TaskManager\Domain\General;

/**
 * @see RaiseEventsTrait
 */
interface RaiseEventsInterface
{
    /**
     * @param object $event
     */
    public function raise(object $event): void;

    /**
     * @return object[]
     */
    public function popEvents(): array;
}
