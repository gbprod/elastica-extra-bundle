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
    private $configurationRepository;

    /**
     * @param IndexConfigurationRepository $configurationRepository
     */
    public function __construct(IndexConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * Handle index creation command
     *
     * @param Client $client
     * @param string $index
     */
    public function handle(Client $client, $index, $type)
    {
        $mapping = $this->configurationRepository->getMapping($index, $type);

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
