<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Command\DeleteIndexCommand;
use GBProd\ElasticaExtraBundle\Handler\DeleteIndexHandler;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\Container;

/**
 * Tests for CreateIndexCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testDeleleIndexCallsHandler()
    {
        $testedInstance = new DeleteIndexCommand();

        $handler = $this->newDeleteIndexHandler();
        $client = $this->newClient();
        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client,
            'gbprod.elastica_extra.delete_index_handler' => $handler,
        ]);
        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'    => 'my_index',
            '--force'  => true,
        ]);

        $output = new NullOutput();

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with($client, 'my_index')
        ;

        $testedInstance->run($input, $output);
    }

    private function newDeleteIndexHandler()
    {
        $handler = $this
            ->getMockBuilder(DeleteIndexHandler::class)
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

    public function testDeleleDoesnotCallHandlerIfNotForced()
    {
        $testedInstance = new DeleteIndexCommand();

        $handler = $this->newDeleteIndexHandler();
        $client = $this->newClient();
        $container = $this->createContainer($client, $handler);
        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'    => 'my_index',
        ]);

        $output = new NullOutput();

        $handler
            ->expects($this->never())
            ->method('handle')
            ->with($client, 'my_index')
        ;

        $testedInstance->run($input, $output);
    }
}
