<?php

namespace Symbio\ApcBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

class SymbioApcExtension extends Extension
{
    const ROOT_NAME = 'symbio_apc';

    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('parameters.yml');

        $config = $processor->process($configuration->getConfigTree(), $configs);

        $container->setParameter('symbio_apc.base_url', $config['base_url']);
        $container->setParameter('symbio_apc.web_dir', $config['web_dir']);
    }
}