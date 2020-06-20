<?php

declare(strict_types=1);

namespace TaskManager\Tests\Unit\Domain\ValueObject;

use DateTime as PhpDateTime;
use PHPUnit\Framework\TestCase;
use TaskManager\Domain\Exception\DateTimeException;
use TaskManager\Domain\ValueObject\DateTime;
use TaskManager\Domain\ValueObject\TaskId;

class TaskIdTest extends TestCase
{
    public function testCreate(): void
    {
        $id = 'task-id';
        $vo = new TaskId($id);
        self::assertEquals($id, $vo->getId());
        self::assertEquals($id, (string) $vo);
    }

    public function testCreateFromString(): void
    {
        $id = 'task-id';
        $vo = TaskId::fromString($id);
        self::assertEquals($id, $vo->getId());
        self::assertEquals($id, (string) $vo);
    }
}
