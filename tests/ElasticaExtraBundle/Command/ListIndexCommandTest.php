<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use Elastica\Index;
use Elastica\Response;
use GBProd\ElasticaExtraBundle\Command\ListIndexCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\Container;

/**
 * Tests for ListIndexCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ListIndexCommandTest extends \PHPUnit_Framework_TestCase
{
    private $testedInstance;
    private $client;
    private $commandTester;

    public function setUp()
    {
        $this->testedInstance = new ListIndexCommand();
        $this->client = $this->prophesize(Client::class);

        $this->container = new Container();
        $this->testedInstance->setContainer($this->container);

        $application = new Application();
        $application->add($this->testedInstance);

        $command = $application->find('elasticsearch:index:list');
        $this->commandTester = new CommandTester($command);
    }

    public function testListIndices()
    {
        $this->client
            ->request('_cat/indices/?h=i')
            ->willReturn($this->createResponseWithData("index1\nindex2"))
        ;

        $this->container->set(
            'gbprod.elastica_extra.default_client',
            $this->client->reveal()
        );

        $this->commandTester->execute([]);

        $this->assertEquals(
            "index1\nindex2\n",
            $this->commandTester->getDisplay()
        );
    }

    private function createResponseWithData($data)
    {
        $response = $this->prophesize(Response::class);
        $response
            ->getData()
            ->willReturn(['message' => $data])
        ;

        return $response;
    }

    public function testListIndicesWithPattern()
    {
        $this->client
            ->request('_cat/indices/user*?h=i')
            ->willReturn($this->createResponseWithData("index1\nindex2"))
        ;

        $this->container->set(
            'gbprod.elastica_extra.default_client',
            $this->client->reveal()
        );

        $this->commandTester->execute([
            '--pattern' => 'user*'
        ]);

        $this->assertEquals(
            "index1\nindex2\n",
            $this->commandTester->getDisplay()
        );
    }
}
