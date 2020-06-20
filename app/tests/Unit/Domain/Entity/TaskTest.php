<?php

declare(strict_types=1);

namespace TaskManager\Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use TaskManager\Domain\Entity\Task;
use TaskManager\Domain\Event\Task\TaskCreatedEvent;
use TaskManager\Domain\Event\Task\TaskFinishedEvent;
use TaskManager\Domain\Event\Task\TaskStartedEvent;
use TaskManager\Domain\Event\Task\TaskUpdatedEvent;
use TaskManager\Domain\ValueObject\DateTime;
use TaskManager\Domain\ValueObject\TaskId;

class TaskTest extends TestCase
{
    public function testCreate(): Task
    {
        $entity = new Task(
            TaskId::fromString('task-id'),
            'title',
            DateTime::now(),
            'description'
        );

        self::assertCount(1, $events = $entity->popEvents());
        self::assertInstanceOf(TaskCreatedEvent::class, $events[0]);

        return $entity;
    }

    /**
     * @depends testCreate
     * @param Task $entity
     * @return Task
     */
    public function testUpdate(Task $entity): Task
    {
        $entity->update('new-title', DateTime::fromString('+1 minute'), null);

        self::assertCount(1, $events = $entity->popEvents());
        self::assertInstanceOf(TaskUpdatedEvent::class, $events[0]);

        return $entity;
    }

    /**
     * @depends testUpdate
     * @param Task $entity
     * @return Task
     */
    public function testStatusChange(Task $entity): Task
    {
        $entity->start();
        $entity->finish();

        self::assertCount(2, $events = $entity->popEvents());

        [$startedEvent, $finishedEvent] = $events;

        self::assertInstanceOf(TaskStartedEvent::class, $startedEvent);
        self::assertInstanceOf(TaskFinishedEvent::class, $finishedEvent);

        return $entity;
    }

    /**
     * @depends testStatusChange
     * @param Task $entity
     */
    public function testInvalidStatusChange(Task $entity): void
    {
        $this->expectException(\DomainException::class);
        $entity->start();
    }
}
