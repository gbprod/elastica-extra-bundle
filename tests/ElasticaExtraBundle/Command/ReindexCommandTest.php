<?php

namespace Tests\GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Command\ReindexCommand;
use GBProd\ElasticaExtraBundle\Handler\ReindexHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Tests for ReindexCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ReindexCommandTest extends TestCase
{
    public function testCommandCallHandler()
    {
        $testedInstance = new ReindexCommand();
        $handler = $this->prophesize(ReindexHandler::class);
        $client = $this->prophesize(Client::class);

        $container = $this->createContainer([
            'gbprod.elastica_extra.default_client'  => $client->reveal(),
            'gbprod.elastica_extra.reindex_handler' => $handler->reveal(),
        ]);

        $testedInstance->setContainer($container);

        $input = new ArrayInput([
            'old-index' => 'my_old_index',
            'new-index' => 'my_new_index',
        ]);

        $output = new NullOutput();

        $handler->handle($client, 'my_old_index', 'my_new_index')
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
}
