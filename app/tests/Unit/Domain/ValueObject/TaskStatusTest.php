<?php

declare(strict_types=1);

namespace TaskManager\Tests\Unit\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use TaskManager\Domain\ValueObject\TaskStatus;

class TaskStatusTest extends TestCase
{
    public function testCreateTodo(): void
    {
        $vo = TaskStatus::createTodo();
        self::assertTrue($vo->isTodo());
        self::assertEquals('todo', (string) $vo);
    }


    public function testCreateInProgress(): void
    {
        $vo = TaskStatus::createInProgress();
        self::assertTrue($vo->isInProgress());
        self::assertEquals('in_progress', (string) $vo);
    }

    public function testCreateDone(): void
    {
        $vo = TaskStatus::createDone();
        self::assertTrue($vo->isDone());
        self::assertEquals('done', (string) $vo);
    }
}
