<?php

namespace Landmarx\Bundle\LandmarkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('landmarx_landmark');

        $rootNode
            ->children()
            ->scalarNode('default_radius')->defaultValue(50)->end()
            ->scalarNode('default_ip')->defaultValue('74.7.133.89')->end()
            ->scalarNode('api_key')->defaultValue('XXXXXXXXXXXXX')->end()
            ->scalarNode('api_secret')->defaultValue('5E(R3T')->end()
            ->end();

        return $treeBuilder;
    }
}
