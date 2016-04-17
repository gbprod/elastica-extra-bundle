<?php

namespace Tests\GBProd\ElasticaExtraBundle;

use GBProd\ElasticaExtraBundle\ElasticaExtraBundle;

/**
 * Tests for bundle
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ElasticaExtraBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $this->assertInstanceOf(
            ElasticaExtraBundle::class, 
            new ElasticaExtraBundle()
        );
    }
}