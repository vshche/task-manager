<?php

declare(strict_types=1);

namespace TaskManager\Tests\Functional\Task;

use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Response;
use TaskManager\Domain\Entity\Task;
use TaskManager\Infrastructure\Persistence\Doctrine\Fixture\TaskFixture;
use TaskManager\Tests\Functional\AbstractTestCase;

class TaskTest extends AbstractTestCase
{
    /**
     * @dataProvider createDataProvider
     * @param array $requestBody
     * @param int   $expectedResponseCode
     */
    public function testCreate(array $requestBody, int $expectedResponseCode): void
    {
        $response = $this->postRequest('/tasks', $requestBody);
        self::assertEquals($expectedResponseCode, $response->getStatusCode(), $response->getContent());

        if ($expectedResponseCode === Response::HTTP_CREATED) {
            self::assertCount(1, $this->em->getRepository(Task::class)->findAll());
        }
    }

    /**
     * @dataProvider updateDataProvider
     * @param array    $requestBody
     * @param int      $expectedResponseCode
     * @param callable $assertions
     */
    public function testUpdate(array $requestBody, int $expectedResponseCode, callable $assertions): void
    {
        $this->loadFixture(TaskFixture::class);
        /* @var Task $task */
        $task = $this->getFixtureReference('task_todo');

        $response = $this->putRequest('/tasks/' . $task->getId(), $requestBody);
        self::assertEquals($expectedResponseCode, $response->getStatusCode(), $response->getContent());

        $assertions(json_decode($response->getContent(), true), $task);
    }

    public function testTransition(): void
    {
        $this->loadFixture(TaskFixture::class);

        /* @var Task $todoTask */
        $todoTask = $this->getFixtureReference('task_todo');

        $response = $this->postRequest(sprintf('/tasks/%s/start', $todoTask->getId()));

        $content = json_decode($response->getContent(), true);

        self::assertEquals('in_progress', $content['status']);

        $response = $this->postRequest(sprintf('/tasks/%s/finish', $todoTask->getId()));

        $content = json_decode($response->getContent(), true);

        self::assertEquals('done', $content['status']);
    }

    public function testGetOne(): void
    {
        $this->loadFixture(TaskFixture::class);
        /* @var Task $todoTask */
        $todoTask = $this->getFixtureReference('task_todo');

        $response = $this->request('GET', sprintf('/tasks/%s', $todoTask->getId()));

        $content = json_decode($response->getContent(), true);
        self::assertEquals($todoTask->getId(), $content['id']);
        self::assertEquals($todoTask->getTitle(), $content['title']);
        self::assertEquals($todoTask->getDescription(), $content['description']);
    }

    public function testSearch(): void
    {
        $this->loadFixture(TaskFixture::class);
        $allTasks = $this->executor->getReferenceRepository()->getReferences();

        $response = $this->request('GET', '/tasks');

        $content = json_decode($response->getContent(), true);
        self::assertCount(count($allTasks), $content);

        $doneTasks = array_filter($allTasks, fn(Task $task) => $task->getStatus()->isDone());

        $response = $this->request('GET', '/tasks?status=done');

        $content = json_decode($response->getContent(), true);
        self::assertCount(count($doneTasks), $content);
    }

    /**
     * @return iterable
     */
    public function createDataProvider(): iterable
    {
        $faker = Factory::create();

        yield [
            [
                'title' => $faker->word,
                'description' => $faker->sentence,
                'due_date' => $faker->dateTime->format(DateTimeInterface::ATOM)
            ],
            Response::HTTP_CREATED
        ];

        yield [
            [
                'title' => $faker->word
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        ];
    }

    /**
     * @return iterable
     */
    public function updateDataProvider(): iterable
    {
        $faker = Factory::create();

        yield [
            $y1 = [
                'title' => $faker->word,
                'description' => $faker->sentence,
                'due_date' => $faker->dateTime->format(DateTimeInterface::ATOM)
            ],
            Response::HTTP_OK,
            static function (array $response, Task $task) use ($y1) {
                self::assertEquals($y1['title'], $response['title']);
                self::assertEquals($y1['description'], $response['description']);
                self::assertEquals($y1['due_date'], $response['due_date']);

                $em = self::$kernel->getContainer()->get('test.service_container')->get(EntityManagerInterface::class);

                $dbTask = $em->find(Task::class, $task->getId());
                self::assertNotNull($dbTask);
                self::assertEquals($y1['title'], $dbTask->getTitle());
            }
        ];
    }
}
