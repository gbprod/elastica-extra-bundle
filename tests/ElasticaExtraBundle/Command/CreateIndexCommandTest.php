<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Command\CreateIndexCommand;
use GBProd\ElasticaExtraBundle\Handler\CreateIndexHandler;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Tests for CreateIndexCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CreateIndexCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateIndexCallsHandler()
    {
        $testedInstance = new CreateIndexCommand();
        $handler = $this->prophesize(CreateIndexHandler::class);
        $client = $this->prophesize(Client::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client->reveal(),
            'gbprod.elastica_extra.create_index_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'  => 'my_index',
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

    public function testThrowExceptionIfClientNotFound()
    {
        $testedInstance = new CreateIndexCommand();
        $handler = $this->prophesize(CreateIndexHandler::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.create_index_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'  => 'my_index',
        ]);

        $output = new NullOutput();

        $this->setExpectedException(\InvalidArgumentException::class);

        $testedInstance->run($input, $output);
    }

    public function testThrowExceptionIfClientIsNotInstanceOfClient()
    {
        $testedInstance = new CreateIndexCommand();
        $handler = $this->prophesize(CreateIndexHandler::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => new \stdClass(),
            'gbprod.elastica_extra.create_index_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'  => 'my_index',
        ]);

        $output = new NullOutput();

        $this->setExpectedException(\InvalidArgumentException::class);

        $testedInstance->run($input, $output);
    }

    public function testExecuteOnDifferentClient()
    {
        $testedInstance = new CreateIndexCommand();
        $handler = $this->prophesize(CreateIndexHandler::class);
        $client = $this->prophesize(Client::class);

        $container = $this->createContainer([
            'my_custom_client' => $client->reveal(),
            'gbprod.elastica_extra.create_index_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'  => 'my_index',
            '--client'  => 'my_custom_client',
        ]);

        $output = new NullOutput();

        $handler
            ->handle($client->reveal(), 'my_index', 'my_index')
            ->shouldBeCalled()
        ;

        $testedInstance->run($input, $output);
    }

    public function testExecuteWithDifferentConfig()
    {
        $testedInstance = new CreateIndexCommand();
        $handler = $this->prophesize(CreateIndexHandler::class);
        $client = $this->prophesize(Client::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client'       => $client->reveal(),
            'gbprod.elastica_extra.create_index_handler' => $handler->reveal(),
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
