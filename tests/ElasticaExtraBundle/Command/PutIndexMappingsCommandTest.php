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
        $handler = $this->prophesize(PutIndexMappingsHandler::class);
        $client = $this->prophesize(Client::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client->reveal(),
            'gbprod.elastica_extra.put_index_mappings_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index' => 'my_index',
            'type'  => 'my_type',
        ]);

        $output = new NullOutput();

        $handler
            ->handle($client->reveal(), 'my_index', 'my_type', 'my_index')
            ->shouldBeCalled()
        ;

        $testedInstance->run($input, $output);
    }

    public function createContainer($services)
    {
        $container = new Container();

        foreach ($services as $serviceName => $service) {
            $container->set($serviceName, $service);
        }

        return $container;
    }

    public function testPutIndexMappingsWithDifferentConfig()
    {
        $testedInstance = new PutIndexMappingsCommand();
        $handler = $this->prophesize(PutIndexMappingsHandler::class);
        $client = $this->prophesize(Client::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client->reveal(),
            'gbprod.elastica_extra.put_index_mappings_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'    => 'my_index',
            'type'     => 'my_type',
            '--alias' => 'my_alias',
        ]);

        $output = new NullOutput();

        $handler
            ->handle($client->reveal(), 'my_index', 'my_type', 'my_alias')
            ->shouldBeCalled()
        ;

        $testedInstance->run($input, $output);
    }
}
