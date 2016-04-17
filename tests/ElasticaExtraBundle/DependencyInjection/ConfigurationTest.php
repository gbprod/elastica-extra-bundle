<?php

namespace Tests\GBProd\ElasticaExtraBundle\DependencyInjection;

use GBProd\ElasticaExtraBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

/**
 * Tests for Configuration
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyConfiguration()
    {
        $testedInstance = new Configuration();

        $processed = $this->process($testedInstance, []);

        $this->assertEquals([
            'default_client' => null,
            'indices' => [],
        ], $processed);
    }

    protected function process($testedInstance, $config)
    {
        $processor = new Processor();

        return $processor->processConfiguration(
            $testedInstance,
            $config
        );
    }

    public function testEmptyIndicesConfiguration()
    {
        $testedInstance = new Configuration();
        $config = [
            [
                'indices' => [
                    'my_index' => [
                        'mappings' => []
                    ],
                    'my_index_2' => [
                    ],
                ]
            ]
        ];

        $processed = $this->process($testedInstance, $config);

        $this->assertArrayHasKey('indices', $processed);
        $this->assertArrayHasKey('my_index', $processed['indices']);
        $this->assertArrayHasKey('my_index_2', $processed['indices']);
    }

    public function testDefaultClientConfiguration()
    {
        $testedInstance = new Configuration();
        $config = [
            [
                'default_client' => 'my_client'
            ]
        ];

        $processed = $this->process($testedInstance, $config);

        $this->assertArrayHasKey('default_client', $processed);
        $this->assertEquals('my_client', $processed['default_client']);
    }
}
