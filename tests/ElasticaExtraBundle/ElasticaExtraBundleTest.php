<?php

namespace Tests\GBProd\ElasticaExtraBundle;

use GBProd\ElasticaExtraBundle\ElasticaExtraBundle;
use PHPUnit\Framework\TestCase;

/**
 * Tests for bundle
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ElasticaExtraBundleTest extends TestCase
{
    public function testConstruction()
    {
        $this->assertInstanceOf(
            ElasticaExtraBundle::class,
            new ElasticaExtraBundle()
        );
    }
}
