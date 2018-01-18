<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use Elastica\Type;
use GBProd\ElasticaExtraBundle\Handler\PutIndexMappingsHandler;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;
use PHPUnit\Framework\TestCase;

/**
 * Tests for PutIndexMappingssHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsHandlerTest extends TestCase
{
    public function testHandle()
    {
        $config = [
            'my_config' => [
                'mappings' => [
                    'my_type' => [
                        'properties' => ['config'],
                    ],
                    'my_type_2' => ['config'],
                ],
            ],
        ];

        $repository = new IndexConfigurationRepository($config);

        $type = $this->prophesize(Type::class);
        $index = $this->newIndex('my_type', $type->reveal());
        $client = $this->newClient('my_index', $index->reveal());

        $testedInstance = new PutIndexMappingsHandler($repository);

        $type->setMapping(['config'])->shouldBeCalled();

        $testedInstance->handle($client->reveal(), 'my_index', 'my_type', 'my_config');
    }

    private function newIndex($typeName, $type)
    {
        $index = $this->prophesize(Index::class);

        $index
            ->getType($typeName)
            ->willReturn($type)
        ;

        return $index;
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

    public function testHandleThrowExceptionIfNoMapping()
    {
        $repository = new IndexConfigurationRepository([]);

        $type = $this->prophesize(Type::class);
        $index = $this->newIndex('my_type', $type->reveal());
        $client = $this->newClient('my_index', $index->reveal());

        $testedInstance = new PutIndexMappingsHandler($repository);

        $this->expectException(\InvalidArgumentException::class);

        $testedInstance->handle($client->reveal(), 'my_index', 'my_type', 'my_config');
    }
}
