<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Command\RemoveAliasCommand;
use GBProd\ElasticaExtraBundle\Handler\RemoveAliasHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Tests for RemoveAliasCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class RemoveAliasCommandTest extends TestCase
{
    public function testCreateIndexCallsHandler()
    {
        $testedInstance = new RemoveAliasCommand();
        $handler = $this->newRemoveAliasHandler();
        $client = $this->newClient();

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client,
            'gbprod.elastica_extra.remove_alias_handler' => $handler,
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'  => 'my_index',
            'alias'  => 'my_alias',
        ]);

        $output = new NullOutput();

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with($client, 'my_index', 'my_alias')
        ;

        $testedInstance->run($input, $output);
    }

    private function newRemoveAliasHandler()
    {
        $handler = $this
            ->getMockBuilder(RemoveAliasHandler::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $handler;
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
