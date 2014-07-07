<?php

namespace Suncat\AdminPageBoardBundle\Block\Loader;

use Sonata\BlockBundle\Exception\BlockNotFoundException;
use Sonata\BlockBundle\Block\BlockLoaderChain as BaseBlockLoaderChain;

/**
 * Class BlockLoaderChain
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class BlockLoaderChain extends BaseBlockLoaderChain
{
    /**
     * {@inheritdoc}
     */
    public function load($block)
    {
        foreach ($this->loaders as $loader) {
            if ($loader->support($block)) {
                try {
                    return $loader->load($block);
                } catch (\RuntimeException $e) {
                    continue;
                }
            }
        }

        throw new BlockNotFoundException;
    }
}
