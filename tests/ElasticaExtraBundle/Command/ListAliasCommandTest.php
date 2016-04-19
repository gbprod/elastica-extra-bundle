<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use Elastica\Index;
use GBProd\ElasticaExtraBundle\Command\ListAliasCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\Container;

/**
 * Tests for ListAliasCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ListAliasCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testPutIndexSettingsCallsHandler()
    {
        $testedInstance = new ListAliasCommand();

        $index = $this->newIndexWithAliases([
            'my-alias-1',
            'my-alias-2',
            'my-alias-3',
        ]);

        $client = $this->newClientWithIndex('my_index', $index);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client,
        ]);

        $testedInstance->setContainer($container);

        $application = new Application();
        $application->add($testedInstance);

        $command = $application->find('elasticsearch:alias:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'index' => 'my_index',
        ]);

        $this->assertRegExp('/my\-alias\-1/', $commandTester->getDisplay());
        $this->assertRegExp('/my\-alias\-2/', $commandTester->getDisplay());
        $this->assertRegExp('/my\-alias\-3/', $commandTester->getDisplay());
    }

    private function newClientWithIndex($indexName, $index)
    {
        $client = $this->newClient();

        $client
            ->expects($this->any())
            ->method('getIndex')
            ->with($indexName)
            ->willReturn($index)
        ;

        return $client;
    }

    private function newIndexWithAliases($aliases)
    {
        $index = $this->newIndex();

        $index
            ->expects($this->any())
            ->method('getAliases')
            ->willReturn($aliases)
        ;

        return $index;
    }

    private function newIndex()
    {
        $index = $this
            ->getMockBuilder(Index::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $index;
    }

    private function newClient()
    {
        $client = $this
            ->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $client;
    }

    public function createContainer($services)
    {
        $container = new Container();

        foreach ($services as $serviceName => $service) {
            $container->set($serviceName, $service);
        }

        return $container;
    }
}
