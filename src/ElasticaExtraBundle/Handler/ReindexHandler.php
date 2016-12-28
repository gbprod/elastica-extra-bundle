<?php

namespace GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use Elastica\Tool\CrossIndex;

/**
 * Handler for reindex
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ReindexHandler
{
    /**
     * @var string
     */
    public static $crossIndexClassname = CrossIndex::class;

    /**
     * Reindex handler
     *
     * @param Client $client
     * @param string $oldIndex
     * @param string $newIndex
     */
    public function handle(Client $client, $oldIndex, $newIndex)
    {
        self::$crossIndexClassname::reindex(
            $client->getIndex($oldIndex),
            $client->getIndex($newIndex)
        );
    }
}
