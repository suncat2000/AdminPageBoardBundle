<?php

namespace Suncat\AdminPageBoardBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class SonataBlockServicePass
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class SonataBlockServicePass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $services = array();
        foreach ($container->findTaggedServiceIds('sonata.block.loader') as $id => $attributes) {
            $services[] = new Reference($id);
        }

        $container->getDefinition('sonata.block.loader.chain')->replaceArgument(0, $services);

        $container->getDefinition('suncat_admin_page_board.block.loader.chain')->replaceArgument(0, $services);
        $container->setAlias('sonata.block.loader.chain', 'suncat_admin_page_board.block.loader.chain');

        $this->applyContext($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    public function applyContext(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('sonata.block.context_manager');

        foreach ($container->getParameter('suncat_admin_page_board.page_boards.blocks') as $pageName => $pageBlocks) {
            foreach ($pageBlocks as $blockConfig) {
                $blockConfig['settings']['route_params'] = null;
                $definition->addMethodCall('addSettingsByType', array($blockConfig['type'], $blockConfig['settings'], true));
            }
        }
    }
}