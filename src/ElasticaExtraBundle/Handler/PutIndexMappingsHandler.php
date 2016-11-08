<?php

namespace GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Handler to put index mappings command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsHandler
{
    /**
     * @var IndexConfigurationRepository
     */
    private $configurations;

    /**
     * @param IndexConfigurationRepository $configurations
     */
    public function __construct(IndexConfigurationRepository $configurations)
    {
        $this->configurations = $configurations;
    }

    /**
     * Handle index creation command
     *
     * @param Client $client
     * @param string $index
     * @param string $type
     * @param string $alias
     */
    public function handle(Client $client, $index, $type, $alias)
    {
        $mapping = $this->configurations->getMapping($alias, $type);

        if (!$mapping) {
            throw new \InvalidArgumentException();
        }

        $client
            ->getIndex($index)
            ->getType($type)
            ->setMapping($mapping)
        ;
    }
}
