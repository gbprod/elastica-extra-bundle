<?php

namespace GBProd\ElasticaExtraBundle\DependencyInjection;

use GBProd\ElasticaExtraBundle\Repository\IndexConfigurationRepository;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Extension class for ElasticsearchExtra bundle
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ElasticaExtraExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->createIndexConfigurationRepository($config, $container);

        if (null !== $config['default_client']) {
            $container->setAlias(
                'gbprod.elastica_extra.default_client',
                $config['default_client']
            );
        }

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('services.yml');
    }

    private function createIndexConfigurationRepository(array $config, ContainerBuilder $container)
    {
        $container
            ->register(
                'gbprod.elastica_extra.index_configuration_repository',
                IndexConfigurationRepository::class
            )
            ->addArgument($config['indices'])
        ;
    }
}
