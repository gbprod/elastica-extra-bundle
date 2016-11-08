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
     * @param string $alias
     */
    public function handle(Client $client, $index, $alias)
    {
        $settings = $this->configurations->getSettings($alias);

        if (null === $settings) {
            throw new \InvalidArgumentException();
        }

        $client->getIndex($index)->setSettings($settings);
    }

}
