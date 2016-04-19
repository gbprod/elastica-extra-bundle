<?php

namespace GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;

/**
 * Handler for remove an alias
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class RemoveAliasHandler
{
    /**
     * Handle remove alias command
     *
     * @param Client $client
     * @param string $index
     * @param string $alias
     */
    public function handle(Client $client, $index, $alias)
    {
        $client
            ->getIndex($index)
            ->removeAlias($alias)
        ;
    }
}
