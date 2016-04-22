<?php

namespace Tests\GBProd\ElasticaExtraBundle\DependencyInjection;

use Elastica\Client;
use GBProd\ElasticaExtraBundle\DependencyInjection\ElasticaExtraExtension;
use GBProd\ElasticaExtraBundle\Handler\AddAliasHandler;
use GBProd\ElasticaExtraBundle\Handler\CreateIndexHandler;
use GBProd\ElasticaExtraBundle\Handler\DeleteIndexHandler;
use GBProd\ElasticaExtraBundle\Handler\PutIndexMappingsHandler;
use GBProd\ElasticaExtraBundle\Handler\PutIndexSettingsHandler;
use GBProd\ElasticaExtraBundle\Handler\RemoveAliasHandler;
use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Tests for Extension class
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ElasticaExtraExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new ElasticaExtraExtension();
    }

    /**
     * @dataProvider allServices
     */
    public function testLoadCreateServices($service, $classname)
    {
        $this->extension->load([], $this->container);

        $this->assertTrue($this->container->has($service));
        $this->assertInstanceOf($classname, $this->container->get($service));
    }

    public function allServices()
    {
        return [
            ['gbprod.elastica_extra.create_index_handler', CreateIndexHandler::class],
            ['gbprod.elastica_extra.index_configuration_repository', IndexConfigurationRepository::class],
            ['gbprod.elastica_extra.delete_index_handler', DeleteIndexHandler::class],
            ['gbprod.elastica_extra.put_index_settings_handler', PutIndexSettingsHandler::class],
            ['gbprod.elastica_extra.put_index_mappings_handler', PutIndexMappingsHandler::class],
            ['gbprod.elastica_extra.add_alias_handler', AddAliasHandler::class],
            ['gbprod.elastica_extra.remove_alias_handler', RemoveAliasHandler::class],
        ];
    }

    public function testLoadSetIndexConfigurations()
    {
        $configs = [
            [
                'indices' => [
                    'my_index' => []
                ]
            ]
        ];

        $this->extension->load($configs, $this->container);
        $argument = $this->container
            ->getDefinition('gbprod.elastica_extra.index_configuration_repository')
            ->getArgument(0)
        ;

        $this->assertEquals([ 'my_index' => [] ], $argument);
    }

    public function testLoadSetAliasForDefaultClient()
    {
        $configs = [
            [
                'default_client' => 'my_client'
            ]
        ];

        $this->extension->load($configs, $this->container);

        $this->assertEquals(
            $this->container->getAlias('gbprod.elastica_extra.default_client'),
            'my_client'
        );
    }
}
