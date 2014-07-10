<?php

namespace Suncat\AdminPageBoardBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Controller\CoreController as BaseCoreController;

/**
 * Class CoreController
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class CoreController extends BaseCoreController
{
    /**
     * @return Response
     */
    public function pageBoardAction()
    {
        $request = $this->getRequest();
        $pageBoardManager = $this->get('suncat_admin_page_board.manager');
        $sonataAdminVersion = $this->container->getParameter('suncat_admin_page_board.sonata_admin_version');

        $pageBlocks = $pageBoardManager->getPageBlocksByRequest($request);

        // adaptation to top,left,center,right,bottom grid
        if ($sonataAdminVersion >= 2.3) {
            $blocks = array(
                'top'    => array(),
                'left'   => array(),
                'center' => array(),
                'right'  => array(),
                'bottom' => array()
            );

            foreach ($pageBlocks as $block) {
                if (
                    in_array($block['position'], array('top', 'bottom')) &&
                    (!isset($block['class']) || null === $block['class'])
                ) {
                    $block['class'] = 'col-md-12';
                }
                $blocks[$block['position']][] = $block;
            }

            $pageBlocks = $blocks;
        }

        return $this->render($pageBoardManager->getTemplate(), array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $pageBlocks
        ));
    }
}
