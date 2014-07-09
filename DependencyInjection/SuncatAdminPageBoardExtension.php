<?php

namespace Suncat\AdminPageBoardBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SuncatAdminPageBoardExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('routes_loader.xml');
        $loader->load('manager.xml');
        $loader->load('block.xml');

        $pageBoardsBlocks = array();
        $routes = array();
        $blockTypes = array();
        foreach ($config['page_boards'] as $pageName => $pageBoard) {
            $pageBoardsBlocks[$pageName] = $pageBoard['blocks'];
            $routes[$pageName] = $pageBoard['route'];

            foreach ($pageBoard['blocks'] as $block) {
                $blockTypes[] = $block['type'];
            }
        }

        $container->setParameter('suncat_admin_page_board.page_boards.blocks', $pageBoardsBlocks);
        $container->setParameter('suncat_admin_page_board.page_boards.routes_config', $routes);

        $container->setParameter('suncat_admin_page_board.routes_prefix_name', $config['routes_prefix_name']);

        if (!class_exists($config['routes_loader_class'])) {
            throw new \RuntimeException(sprintf('Class \'%s\' not exist', $config['routes_loader_class']));
        }
        if (!class_exists($config['routes_config_class'])) {
            throw new \RuntimeException(sprintf('Class \'%s\' not exist', $config['routes_config_class']));
        }

        $container->setParameter('suncat_admin_page_board.routes_loader.class', $config['routes_loader_class']);
        $container->setParameter('suncat_admin_page_board.routes_config.class', $config['routes_config_class']);
        $container->setParameter('suncat_admin_page_board.page_board_template', $config['page_board_template']);

        $container->setParameter('suncat_admin_page_board.sonata_admin_layout_template', $config['sonata_admin_layout_template']);
        $container->setParameter('suncat_admin_page_board.sonata_admin_version', $config['sonata_admin_version']);
        $container->setParameter('suncat_admin_page_board.sonata_admin_list_builder_class', $config['sonata_admin_list_builder_class']);

        $container->getDefinition('suncat_admin_page_board.block.loader')->replaceArgument(0, $blockTypes);
    }
}
