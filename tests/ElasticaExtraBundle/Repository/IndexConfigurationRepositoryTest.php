<?php

namespace Tests\GBProd\ElasticaExtraBundle\Repository;

use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;
use PHPUnit\Framework\TestCase;

/**
 * Tests for IndexConfigurationRepository
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class IndexConfigurationRepositoryTest extends TestCase
{
    public function testGetReturnsConfig()
    {
        $configs = [
            'my_index' => ['my' => 'config'],
        ];

        $testedInstance = new IndexConfigurationRepository($configs);

        $config = $testedInstance->get('my_index');

        $this->assertEquals(['my' => 'config'], $config);
    }

    public function testGetReturnsNullIfIndexNotExists()
    {
        $configs = [
            'my_index' => ['my' => 'config'],
        ];

        $testedInstance = new IndexConfigurationRepository($configs);

        $config = $testedInstance->get('not_my_index');

        $this->assertNull($config);
    }

    public function testGetSettings()
    {
        $configs = [
            'my_index' => ['settings' => ['number_of_replicas' => 8]],
            'my_index_2' => [],
        ];

        $testedInstance = new IndexConfigurationRepository($configs);

        $settings = $testedInstance->getSettings('my_index');
        $this->assertEquals(['number_of_replicas' => 8], $settings);

        $settings = $testedInstance->getSettings('my_index_fake');
        $this->assertEquals(null, $settings);

        $settings = $testedInstance->getSettings('my_index_2');
        $this->assertEquals([], $settings);
    }

    public function testGetMapping()
    {
        $configs = [
            'my_index' => [
                'mappings' => [
                    'my_type' => [
                        'properties' => ['property' => 'value'],
                    ],
                    'my_type_2' => ['config'],
                ],
            ],
        ];

        $testedInstance = new IndexConfigurationRepository($configs);

        $mapping = $testedInstance->getMapping('my_index', 'my_type');
        $this->assertEquals(['property' => 'value'], $mapping);

        $mapping = $testedInstance->getMapping('my_index', 'my_type_2');
        $this->assertEquals([], $mapping);

        $mapping = $testedInstance->getMapping('my_index', 'my_type_fake');
        $this->assertEquals(null, $mapping);
    }

    public function testGetMappings()
    {
        $configs = [
            'my_index' => [
                'mappings' => [
                    'my_type' => ['config'],
                    'my_type_2' => ['config'],
                ],
            ],
        ];

        $testedInstance = new IndexConfigurationRepository($configs);

        $mappings = $testedInstance->getMappings('my_index');

        $this->assertEquals([
            'my_type' => ['config'],
            'my_type_2' => ['config'],
        ], $mappings);
    }

}
