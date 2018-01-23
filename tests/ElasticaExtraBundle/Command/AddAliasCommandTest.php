<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Command\AddAliasCommand;
use GBProd\ElasticaExtraBundle\Handler\AddAliasHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Tests for AddAliasCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class AddAliasCommandTest extends TestCase
{
    public function testCreateIndexCallsHandler()
    {
        $testedInstance = new AddAliasCommand();
        $handler = $this->newAddAliasHandler();
        $client = $this->newClient();

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client,
            'gbprod.elastica_extra.add_alias_handler' => $handler,
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
            ->with($client, 'my_index', 'my_alias', false)
        ;

        $testedInstance->run($input, $output);
    }

    private function newAddAliasHandler()
    {
        $handler = $this
            ->getMockBuilder(AddAliasHandler::class)
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
