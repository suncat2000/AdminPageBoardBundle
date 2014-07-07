<?php

namespace Suncat\AdminPageBoardBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('suncat_admin_page_board');

        $rootNode
            ->children()
                ->arrayNode('page_boards')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('blocks')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('type')->cannotBeEmpty()->end()
                                        ->arrayNode('settings')
                                            ->useAttributeAsKey('id')
                                            ->prototype('variable')->defaultValue(array())->end()
                                        ->end()
                                        ->scalarNode('position')->defaultValue('right')->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('route')
                                ->children()
                                    ->scalarNode('name')->defaultNull()->end()
                                    ->scalarNode('prefix')->defaultValue('/admin')->end()
                                    ->scalarNode('path')->cannotBeEmpty()->end()
                                    ->scalarNode('host')->defaultValue('')->end()
                                    ->arrayNode('schemes')
                                        ->prototype('variable')->defaultValue(array())->end()
                                    ->end()
                                    ->arrayNode('requirements')
                                        ->prototype('variable')->defaultValue(array())->end()
                                    ->end()
                                    ->arrayNode('options')
                                        ->prototype('variable')->defaultValue(array())->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('routes_prefix_name')->defaultValue('sonata_admin_page_board')->end()
                ->scalarNode('routes_loader_class')->defaultValue('Suncat\AdminPageBoardBundle\Routing\RouteLoader')->end()
                ->scalarNode('routes_config_class')->defaultValue('Suncat\AdminPageBoardBundle\Routing\RouteConfig')->end()
                ->scalarNode('sonata_admin_layout_template')->defaultNull('SuncatAdminPageBoardBundle::layout.html.twig')->end()
                ->scalarNode('page_board_template')->defaultValue('SuncatAdminPageBoardBundle:Core:page_board.html.twig')->end()
            ->end();

        return $treeBuilder;
    }
}
