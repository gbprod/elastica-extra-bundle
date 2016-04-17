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
            'my_index' => [
                'settings' => [
                    'awesome' => 'config'
                    ],
                'foo' => 'bar',
            ]
        ];
        
        $index = $this->newIndex();
        $client = $this->newClient('my_index', $index);
        
        $repository = new IndexConfigurationRepository($config);
        
        $testedInstance = new CreateIndexHandler($repository);
        
        $index
            ->expects($this->once())
            ->method('create')
            ->with([
                'settings' => [
                    'awesome' => 'config'
                    ],
                'foo' => 'bar',
            ])
        ;
        
        $testedInstance->handle($client, 'my_index');
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
        
        $testedInstance = new CreateIndexHandler($repository);
        
        $this->setExpectedException(\InvalidArgumentException::class);
        
        $testedInstance->handle($client, 'my_index');
    }
}
