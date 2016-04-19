<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use GBProd\ElasticaExtraBundle\Handler\RemoveAliasHandler;

/**
 * Tests for RemoveAliasHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class RemoveAliasHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandle()
    {
        $index = $this->newIndex();
        $client = $this->newClient('my_index', $index);

        $testedInstance = new RemoveAliasHandler();

        $index
            ->expects($this->once())
            ->method('removeAlias')
            ->with('my-alias')
        ;

        $testedInstance->handle($client, 'my_index', 'my-alias');
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
