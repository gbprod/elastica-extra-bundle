<?php

namespace GBProd\ElasticaExtraBundle\Exception;

/**
 * Exception thrown if index has not been found
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class IndexNotFoundException extends \Exception
{
    /**
     * @var string
     */
    private $index;

    /**
     * @param string $index
     */
    public function __construct($index)
    {
        $this->index = $index;
    }

    /**
     * Get index name
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }
}