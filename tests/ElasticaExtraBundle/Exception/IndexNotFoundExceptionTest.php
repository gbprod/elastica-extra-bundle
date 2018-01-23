<?php

namespace Tests\GBProd\ElasticaExtraBundle\Exception;

use GBProd\ElasticaExtraBundle\Exception\IndexNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Tests for IndexNotFoundException
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class IndexNotFoundExceptionTest extends TestCase
{
    public function testConstruct()
    {
        $exception = new IndexNotFoundException('index');

        $this->assertInstanceOf(IndexNotFoundException::class, $exception);
        $this->assertEquals('index', $exception->getIndex());
    }
}
