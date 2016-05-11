<?php

namespace GBProd\ElasticaExtraBundle\Handler;

use GBProd\ElasticaExtraBundle\Exception\IndexNotFoundException;
use Elastica\Client;

/**
 * Handler to delete index command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexHandler
{
    /**
     * Handle index deletion command
     *
     * @param Client $client
     * @param string $index
     *
     * @throws IndexNotFoundException
     */
    public function handle(Client $client, $index)
    {
        $index = $client->getIndex($index);

        if (!$index->exists()) {
            throw new IndexNotFoundException($index);
        }

        $index->delete();
    }
}
