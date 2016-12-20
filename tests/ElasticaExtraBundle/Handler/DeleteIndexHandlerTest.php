<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use GBProd\ElasticaExtraBundle\Exception\IndexNotFoundException;
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
        $index = $this->newIndex();
        $client = $this->newClient('my_index', $index);

        $testedInstance = new DeleteIndexHandler();

        $index
            ->expects($this->once())
            ->method('delete')
        ;

        $index
            ->expects($this->any())
            ->method('exists')
            ->willReturn(true)
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

    public function testHandleOnNotExistingIndexThrowException()
    {
        $index = $this->newIndex();
        $client = $this->newClient('my_index', $index);

        $testedInstance = new DeleteIndexHandler();

        $index
            ->expects($this->never())
            ->method('delete')
        ;

        $index
            ->expects($this->any())
            ->method('exists')
            ->willReturn(false)
        ;

        $this->setExpectedException(IndexNotFoundException::class);

        $testedInstance->handle($client, 'my_index');
    }
}
