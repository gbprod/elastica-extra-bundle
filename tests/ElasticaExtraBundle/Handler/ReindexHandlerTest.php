<?php

namespace Tests\GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Index;
use GBProd\ElasticaExtraBundle\Handler\ReindexHandler;

/**
 * Tests for ReindexHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ReindexHandlerTest extends \PHPUnit_Framework_TestCase
{
    private static $expectedReindexParameters = [];

    public function testHandle()
    {
        ReindexHandler::$crossIndexClassname = self::class;

        $client = $this->prophesize(Client::class);

        $oldIndex = $this->prophesize(Index::class);
        $client
            ->getIndex('old-index')
            ->willReturn($oldIndex->reveal())
        ;

        $newIndex = $this->prophesize(Index::class);
        $client
            ->getIndex('new-index')
            ->willReturn($newIndex->reveal())
        ;

        $this->setExpectedReindexCall($oldIndex->reveal(), $newIndex->reveal());

        $handler = new ReindexHandler();
        $handler->handle($client->reveal(), 'old-index', 'new-index');
    }

    public static function reindex(Index $oldIndex, Index $newIndex)
    {
        self::assertEquals(self::$expectedReindexParameters, func_get_args());
    }

    public function setExpectedReindexCall(Index $oldIndex, Index $newIndex)
    {
        self::$expectedReindexParameters = [$oldIndex, $newIndex];
    }
}
