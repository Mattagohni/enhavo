<?php

namespace Enhavo\Bundle\ThemeBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('enhavo_theme');

        $rootNode
            ->children()
                ->arrayNode('boxes')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('template')->end()
                            ->variableNode('widgets')->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('base')->defaultValue('EnhavoThemeBundle:Theme:base.html.twig')->end()
                    ->end()
                ->end()


                ->arrayNode('route')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('url_resolver')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                            ->children()
                                ->scalarNode('model')->end()
                                ->scalarNode('strategy')->end()
                                ->scalarNode('route')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();



        return $treeBuilder;
    }
}
