<?php

namespace GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;

/**
 * Handler for add an alias
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class AddAliasHandler
{
    /**
     * Handle add alias command
     *
     * @param Client $client
     * @param string $index
     * @param string $alias
     * @param bool   $replace
     */
    public function handle(Client $client, $index, $alias, $replace = false)
    {
        $client
            ->getIndex($index)
            ->addAlias($alias, $replace)
        ;
    }
}
