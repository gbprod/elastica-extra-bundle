<?php

namespace Tests\GBProd\ElasticaExtraBundle\Repository;

use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Tests for IndexConfigurationRepository
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class IndexConfigurationRepositoryTest extends \PHPUnit_Framework_TestCase
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
        ];
        
        $testedInstance = new IndexConfigurationRepository($configs);
        
        $settings = $testedInstance->getSettings('my_index');

        $this->assertEquals(['number_of_replicas' => 8], $settings);
    }

    public function testGetMapping()
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
        
        $mapping = $testedInstance->getMapping('my_index', 'my_type');

        $this->assertEquals(['config'], $mapping);
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
