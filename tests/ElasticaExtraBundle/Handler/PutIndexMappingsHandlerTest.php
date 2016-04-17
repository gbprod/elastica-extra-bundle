<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use Elastica\Type;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;
use GBProd\ElasticaExtraBundle\Handler\PutIndexMappingsHandler;

/**
 * Tests for PutIndexMappingssHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandle()
    {
        $config = [
            'my_index' => [
                'mappings' => [
                    'my_type' => ['config'],
                    'my_type_2' => ['config'],
                ],
            ],
        ];
        
        $repository = new IndexConfigurationRepository($config);

        $type = $this->newType();
        $index = $this->newIndex('my_type', $type);
        $client = $this->newClient('my_index', $index);
        
        $testedInstance = new PutIndexMappingsHandler($repository);
        
        $type
            ->expects($this->once())
            ->method('setMapping')
            ->with(['config'])
        ;
        
        $testedInstance->handle($client, 'my_index', 'my_type');
    }
    
    private function newType()
    {
        return $this
            ->getMockBuilder(Type::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
    private function newIndex($typeName, $type)
    {
        $index = $this
            ->getMockBuilder(Index::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        
        $index
            ->expects($this->any())
            ->method('getType')
            ->with($typeName)
            ->willReturn($type)
        ;
        
        return $index;
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
    
    public function testHandleThrowExceptionIfNoMapping()
    {
        $repository = new IndexConfigurationRepository([]);

        $type = $this->newType();
        $index = $this->newIndex('my_type', $type);
        $client = $this->newClient('my_index', $index);
        
        $testedInstance = new PutIndexMappingsHandler($repository);
        
        $this->setExpectedException(\InvalidArgumentException::class);

        $testedInstance->handle($client, 'my_index', 'my_type');
    }
}
