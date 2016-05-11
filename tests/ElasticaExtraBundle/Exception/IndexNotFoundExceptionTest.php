<?php

namespace Tests\GBProd\ElasticaExtraBundle\Exception;

use GBProd\ElasticaExtraBundle\Exception\IndexNotFoundException;

/**
 * Tests for IndexNotFoundException
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class IndexNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $exception = new IndexNotFoundException('index');

        $this->assertInstanceOf(IndexNotFoundException::class, $exception);
        $this->assertEquals('index', $exception->getIndex());
    }
}
