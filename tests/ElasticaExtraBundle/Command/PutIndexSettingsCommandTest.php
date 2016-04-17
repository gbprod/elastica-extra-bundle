<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Command\PutIndexSettingsCommand;
use GBProd\ElasticaExtraBundle\Handler\PutIndexSettingsHandler;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\Container;

/**
 * Tests for PutIndexSettingsCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexSettingsCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testPutIndexSettingsCallsHandler()
    {
        $testedInstance = new PutIndexSettingsCommand();
        $handler = $this->newPutIndexSettingsHandler();
        $client = $this->newClient();

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client,
            'gbprod.elastica_extra.put_index_settings_handler' => $handler,
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index' => 'my_index',
        ]);

        $output = new NullOutput();

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with($client, 'my_index')
        ;

        $testedInstance->run($input, $output);
    }

    private function newPutIndexSettingsHandler()
    {
        $handler = $this
            ->getMockBuilder(PutIndexSettingsHandler::class)
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
