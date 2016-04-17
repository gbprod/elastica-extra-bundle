<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Command\PutIndexMappingsCommand;
use GBProd\ElasticaExtraBundle\Handler\PutIndexMappingsHandler;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\Container;

/**
 * Tests for PutIndexMappingsCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testPutIndexMappingsCallsHandler()
    {
        $testedInstance = new PutIndexMappingsCommand();
        $handler = $this->newPutIndexMappingsHandler();
        $client = $this->newClient();

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client,
            'gbprod.elastica_extra.put_index_mappings_handler' => $handler,
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index' => 'my_index',
            'type'  => 'my_type',
        ]);

        $output = new NullOutput();

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with($client, 'my_index', 'my_type')
        ;

        $testedInstance->run($input, $output);
    }

    private function newPutIndexMappingsHandler()
    {
        $handler = $this
            ->getMockBuilder(PutIndexMappingsHandler::class)
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
