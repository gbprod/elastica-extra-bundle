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
        $handler = $this->newCreateIndexHandler();
        $client = $this->newClient();

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => $client,
            'gbprod.elastica_extra.create_index_handler' => $handler,
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'  => 'my_index',
        ]);

        $output = new NullOutput();

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with($client, 'my_index')
        ;

        $testedInstance->run($input, $output);
    }

    private function newCreateIndexHandler()
    {
        $handler = $this
            ->getMockBuilder(CreateIndexHandler::class)
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

    public function testThrowExceptionIfClientNotFound()
    {
        $testedInstance = new CreateIndexCommand();
        $handler = $this->newCreateIndexHandler();

        $container = $this->createContainer([
            'gbprod.elastica_extra.create_index_handler' => $handler,
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
        $handler = $this->newCreateIndexHandler();

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client' => new \stdClass(),
            'gbprod.elastica_extra.create_index_handler' => $handler,
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
        $handler = $this->newCreateIndexHandler();
        $client = $this->newClient();

        $container = $this->createContainer([
            'my_custom_client' => $client,
            'gbprod.elastica_extra.create_index_handler' => $handler,
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'index'  => 'my_index',
            '--client'  => 'my_custom_client',
        ]);

        $output = new NullOutput();

        $handler
            ->expects($this->once())
            ->method('handle')
            ->with($client, 'my_index')
        ;

        $testedInstance->run($input, $output);
    }
}
