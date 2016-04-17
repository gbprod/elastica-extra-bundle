<?php

namespace GBProd\ElasticaExtraBundle\Handler;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\Repository\ClientRepository;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Handler to put index settings command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexSettingsHandler
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
        $settings = $this
            ->configurationRepository
            ->getSettings($index)
        ;

        if (null === $settings) {
            throw new \InvalidArgumentException();
        }

        $client
            ->getIndex($index)
            ->setSettings($settings)
        ;
    }

}
