<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;
use GBProd\ElasticaExtraBundle\Handler\DeleteIndexHandler;

/**
 * Tests for DeleteIndexHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandle()
    {
        $config = ['my' => ['awesome' => 'config']];
        
        $index = $this->newIndex();
        $client = $this->newClient('my_index', $index);
        
        $testedInstance = new DeleteIndexHandler($repository);
        
        $index
            ->expects($this->once())
            ->method('delete')
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
}
