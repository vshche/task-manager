<?php

declare(strict_types=1);

namespace TaskManager\Tests\Functional;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AbstractTestCase extends WebTestCase
{
    protected ORMExecutor $executor;
    protected EntityManagerInterface $em;
    protected KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $this->em = self::$kernel->getContainer()->get('test.service_container')->get(EntityManagerInterface::class);
        $this->executor = new ORMExecutor($this->em, new ORMPurger());

        $schemaTool = new SchemaTool($this->em);
        try {
            $schemaTool->dropDatabase();
        } catch (\Throwable $e) {}
        $schemaTool->createSchema($this->em->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @param string|array $fixture
     */
    protected function loadFixture($fixture): void
    {
        $loader = new Loader();
        $fixtures = is_array($fixture) ? $fixture : [$fixture];
        foreach ($fixtures as $item) {
            $loader->addFixture(new $item());
        }
        $this->executor->execute($loader->getFixtures());
    }

    /**
     * @param string $name
     * @return object
     */
    protected function getFixtureReference(string $name): object
    {
        return $this->executor->getReferenceRepository()->getReference($name);
    }

    /**
     * @param string $uri
     * @param array  $body
     * @return Response
     */
    protected function postRequest(string $uri, array $body = []): Response
    {
        return $this->request('POST', $uri, $body);
    }

    /**
     * @param string $uri
     * @param array  $body
     * @return Response
     */
    protected function putRequest(string $uri, array $body = []): Response
    {
        return $this->request('PUT', $uri, $body);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $body
     * @return Response
     */
    protected function request(string $method, string $uri, array $body = []): Response
    {
        $this->client->request(
            $method,
            $uri,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($body)
        );
        return $this->client->getResponse();
    }
}
