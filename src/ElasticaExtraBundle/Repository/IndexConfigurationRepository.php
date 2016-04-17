<?php

namespace GBProd\ElasticaExtraBundle\Repository;

/**
 * Repository for index configuration
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class IndexConfigurationRepository
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * Get all configuration for an index
     *
     * @param string $index
     *
     * @return array|null
     */
    public function get($index)
    {
        if (!isset($this->config[$index])) {
            return null;
        }

        return $this->config[$index];
    }

    /**
     * Get settings for an index
     *
     * @param string $index
     *
     * @return array|null
     */
    public function getSettings($index)
    {
        $config = $this->get($index);

        if (null === $config) {
            return null;
        }

        if (!isset($config['settings'])) {
            return [];
        }

        return $config['settings'];
    }

    /**
     * Get mappings for an index
     *
     * @param string $index
     *
     * @return array|null
     */
    public function getMappings($index)
    {
        $config = $this->get($index);

        if (null === $config || !isset($config['mappings'])) {
            return null;
        }

        return $config['mappings'];
    }

    /**
     * Get mapping for a type
     *
     * @param string $index
     * @param string $type
     *
     * @return array|null
     */
    public function getMapping($index, $type)
    {
        $mappings = $this->getMappings($index);

        if (!isset($mappings[$type])) {
            return null;
        }

        if (!isset($mappings[$type]['properties'])) {
            return [];
        }

        return $mappings[$type]['properties'];
    }
}
