<?php

namespace GBProd\ElasticaExtraBundle\Handler;

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
     */
    public function handle(Client $client, $index)
    {
        $client->getIndex($index)->delete();
    }
}
