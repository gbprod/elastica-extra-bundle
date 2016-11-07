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
     * @param string $configName
     */
    public function handle(Client $client, $index, $configName)
    {
        $config = $this->configurations->get($configName);

        if (null === $config) {
            throw new \InvalidArgumentException();
        }

        $client
            ->getIndex($index)
            ->create($config)
        ;
    }
}
