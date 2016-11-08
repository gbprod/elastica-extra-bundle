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
        $handler = $this->prophesize(PutIndexSettingsHandler::class);
        $client = $this->prophesize(Client::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client->reveal(),
            'gbprod.elastica_extra.put_index_settings_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index' => 'my_index',
        ]);

        $output = new NullOutput();

        $handler
            ->handle($client->reveal(), 'my_index', 'my_index')
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

    public function testPutIndexSettingsWithDifferentConfiguration()
    {
        $testedInstance = new PutIndexSettingsCommand();
        $handler = $this->prophesize(PutIndexSettingsHandler::class);
        $client = $this->prophesize(Client::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client->reveal(),
            'gbprod.elastica_extra.put_index_settings_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'   => 'my_index',
            '--alias' => 'my_alias',
        ]);

        $output = new NullOutput();

        $handler
            ->handle($client->reveal(), 'my_index', 'my_alias')
            ->shouldBeCalled()
        ;

        $testedInstance->run($input, $output);
    }
}
