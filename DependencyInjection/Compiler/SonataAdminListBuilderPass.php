<?php

namespace Suncat\AdminPageBoardBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class SonataAdminListBuilderPass
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class SonataAdminListBuilderPass implements CompilerPassInterface
{
    /**
     * @see Symfony\Component\DependencyInjection\Compiler.CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        $adminPageBoardListBuilderClass = $container->getParameter('suncat_admin_page_board.sonata_admin_list_builder_class');

        $definition = $container->getDefinition('sonata.admin.builder.orm_list');
        $definition->setClass($adminPageBoardListBuilderClass);
    }
}