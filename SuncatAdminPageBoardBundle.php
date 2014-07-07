<?php

namespace Suncat\AdminPageBoardBundle;

use Suncat\AdminPageBoardBundle\DependencyInjection\Compiler\SonataBlockServicePass;
use Suncat\AdminPageBoardBundle\DependencyInjection\Compiler\SonataAdminConfigPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SuncatAdminPageBoardBundle
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class SuncatAdminPageBoardBundle extends Bundle
{
    protected $parent;

    /**
     * @param string $parent
     */
    public function __construct($parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @see Symfony\Component\HttpKernel\Bundle.Bundle::registerExtensions()
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new SonataAdminConfigPass());
        $container->addCompilerPass(new SonataBlockServicePass());
    }

}
