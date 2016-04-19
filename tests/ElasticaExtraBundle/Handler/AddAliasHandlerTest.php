<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use GBProd\ElasticaExtraBundle\Handler\AddAliasHandler;

/**
 * Tests for AddAliasHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class AddAliasHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandle()
    {
        $index = $this->newIndex();
        $client = $this->newClient('my_index', $index);

        $testedInstance = new AddAliasHandler();

        $index
            ->expects($this->once())
            ->method('addAlias')
            ->with('my-alias', true)
        ;

        $testedInstance->handle($client, 'my_index', 'my-alias', true);
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
