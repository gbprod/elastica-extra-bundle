<?php

namespace GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Handler for create index command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CreateIndexHandler
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
    public function handle(Client $client, $index)
    {
        $config = $this->configurationRepository->get($index);

        if (null === $config) {
            throw new \InvalidArgumentException();
        }

        $client
            ->getIndex($index)
            ->create($config)
        ;
    }
}
