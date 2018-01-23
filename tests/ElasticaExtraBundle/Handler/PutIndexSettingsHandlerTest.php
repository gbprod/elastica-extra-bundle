<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use GBProd\ElasticaExtraBundle\Handler\PutIndexSettingsHandler;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;
use PHPUnit\Framework\TestCase;

/**
 * Tests for PutIndexSettingsHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexSettingsHandlerTest extends TestCase
{
    public function testHandle()
    {
        $config =  [
            'my_alias' => [
                'settings' => [
                    'awesome' => 'config'
                    ],
                'foo' => 'bar',
            ]
        ];

        $index = $this->newIndex();
        $client = $this->newClient('my_index', $index);
        $repository = new IndexConfigurationRepository($config);

        $testedInstance = new PutIndexSettingsHandler($repository);

        $index
            ->expects($this->once())
            ->method('setSettings')
            ->with(['awesome' => 'config'])
        ;

        $testedInstance->handle($client, 'my_index', 'my_alias');
    }

    private function newIndex()
    {
        return $this
            ->getMockBuilder(Index::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    private function newClient($indexName, $index)
    {
        $client = $this
            ->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $client
            ->expects($this->any())
            ->method('getIndex')
            ->with($indexName)
            ->willReturn($index)
        ;

        return $client;
    }

    public function testHandleThrowExceptionIfNoConfiguration()
    {
        $index = $this->newIndex();
        $client = $this->newClient('my_index', $index);
        $repository = new IndexConfigurationRepository([]);

        $testedInstance = new PutIndexSettingsHandler($repository);

        $this->expectException(\InvalidArgumentException::class);

        $testedInstance->handle($client, 'my_index', 'my_alias');
    }
}
