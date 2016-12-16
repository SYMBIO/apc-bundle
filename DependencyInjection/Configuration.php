<?php

namespace Symbio\ApcBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\NodeInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 */
class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root(SymbioApcExtension::ROOT_NAME, 'array')
            /*->children()
                ->scalarNode('host_ip')->isRequired()->end()
                ->scalarNode('host_name')->isRequired()->end()
                ->scalarNode('web_dir')->isRequired()->end()
                ->enumNode('protocol')->values(array('http', 'https'))->defaultValue('http')->end()
            ->end()*/
        ->end();

        return $treeBuilder->buildTree();
    }
}
