<?php

namespace GBProd\ElasticaExtraBundle\Command;

use Elastica\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Command tha use elasticsearch client from container
 *
 * @author gbprod <contact@gb-prod.fr>
 */
abstract class ElasticaAwareCommand extends ContainerAwareCommand
{
    /**
     * Get elasticsearch client from his name
     *
     * @param string $clientName
     *
     * @return Client
     */
    protected function getClient($clientName)
    {
        $clientName = $clientName ?: 'gbprod.elastica_extra.default_client';

        $client = $this->getContainer()
            ->get(
                $clientName,
                ContainerInterface::NULL_ON_INVALID_REFERENCE
            )
        ;

        $this->validateClient($client, $clientName);

        return $client;
    }

    protected function validateClient($client, $clientName)
    {
        if (!$client) {
            throw new \InvalidArgumentException(sprintf(
                'No client "%s" found',
                $clientName
            ));
        }

        if (!$client instanceof Client) {
            throw new \InvalidArgumentException(sprintf(
                'Client "%s" should be instance of "%s"',
                $clientName,
                Client::class
            ));
        }
    }
}
