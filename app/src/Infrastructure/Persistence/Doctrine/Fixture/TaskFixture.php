<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Persistence\Doctrine\Fixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use TaskManager\Domain\Entity\Task;
use TaskManager\Domain\ValueObject\DateTime;
use TaskManager\Domain\ValueObject\TaskId;

class TaskFixture extends Fixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $this->addReference(
            'task_todo',
            new Task(
                new TaskId($faker->uuid),
                $faker->word,
                DateTime::fromDateTime($faker->dateTime)
            )
        );

        $inProgressTask = new Task(
            new TaskId($faker->uuid),
            $faker->word,
            DateTime::fromDateTime($faker->dateTime),
        );
        $inProgressTask->start();
        $this->addReference('task_in_progress', $inProgressTask);

        $doneTask = new Task(
            new TaskId($faker->uuid),
            $faker->word,
            DateTime::fromDateTime($faker->dateTime),
        );
        $doneTask->start();
        $doneTask->finish();
        $this->addReference('task_done', $doneTask);

        $manager->persist($this->getReference('task_todo'));
        $manager->persist($this->getReference('task_in_progress'));
        $manager->persist($this->getReference('task_done'));

        $manager->flush();
    }
}
