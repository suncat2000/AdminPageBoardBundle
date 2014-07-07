<?php

namespace Suncat\AdminPageBoardBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class SonataAdminConfigPass
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class SonataAdminConfigPass implements CompilerPassInterface
{
    /**
     * @see Symfony\Component\DependencyInjection\Compiler.CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        $adminPageBoardLayout = $container->getParameter('suncat_admin_page_board.sonata_admin_layout_template');

        if (
            null !== $adminPageBoardLayout &&
            strlen($adminPageBoardLayout) > 0 &&
            $container->hasParameter('sonata.admin.configuration.templates')
        )
        {
            $templates = $container->getParameter('sonata.admin.configuration.templates');
            $templates['layout'] = $adminPageBoardLayout;
            $container->setParameter('sonata.admin.configuration.templates', $templates);
        }
    }
}