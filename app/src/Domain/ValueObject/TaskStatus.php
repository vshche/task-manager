<?php

declare(strict_types=1);

namespace TaskManager\Domain\ValueObject;

final class TaskStatus
{
    private const TODO = 'todo';
    private const IN_PROGRESS = 'in_progress';
    private const DONE = 'done';

    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return TaskStatus
     */
    public static function createTodo(): self
    {
        return new self(self::TODO);
    }

    /**
     * @return TaskStatus
     */
    public static function createInProgress(): self
    {
        return new self(self::IN_PROGRESS);
    }

    /**
     * @return TaskStatus
     */
    public static function createDone(): self
    {
        return new self(self::DONE);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isTodo(): bool
    {
        return $this->value === self::TODO;
    }

    /**
     * @return bool
     */
    public function isInProgress(): bool
    {
        return $this->value === self::IN_PROGRESS;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->value === self::DONE;
    }
}
