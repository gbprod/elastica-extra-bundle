<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;
use GBProd\ElasticaExtraBundle\Handler\CreateIndexHandler;

/**
 * Tests for CreateIndexHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CreateIndexHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandle()
    {
        $config =  [
            'my_config' => [
                'settings' => [
                    'awesome' => 'config'
                ],
                'foo' => 'bar',
            ]
        ];

        $index = $this->prophesize(Index::class);
        $client = $this->newClient('my_index', $index->reveal());

        $repository = new IndexConfigurationRepository($config);

        $testedInstance = new CreateIndexHandler($repository);

        $index->create([
                'settings' => [
                    'awesome' => 'config'
                ],
                'foo' => 'bar',
            ])
            ->shouldBeCalled()
        ;

        $testedInstance->handle($client->reveal(), 'my_index', 'my_config');
    }

    private function newClient($indexName, $index)
    {
        $client = $this->prophesize(Client::class);

        $client
            ->getIndex($indexName)
            ->willReturn($index)
        ;

        return $client;
    }

    public function testHandleThrowExceptionIfNoConfiguration()
    {
        $index = $this->prophesize(Index::class);
        $client = $this->newClient('my_index', $index->reveal());
        $repository = new IndexConfigurationRepository([]);

        $testedInstance = new CreateIndexHandler($repository);

        $this->setExpectedException(\InvalidArgumentException::class);

        $testedInstance->handle($client->reveal(), 'my_index', 'my_config');
    }
}
