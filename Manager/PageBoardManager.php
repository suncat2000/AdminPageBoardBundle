<?php

namespace Suncat\AdminPageBoardBundle\Manager;

use Suncat\AdminPageBoardBundle\Routing\RouteConfig;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageBoardManager
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class PageBoardManager
{
    /**
     * @var array
     */
    protected $pageBlocks;

    /**
     * @var \Suncat\AdminPageBoardBundle\Routing\RouteConfig
     */
    protected $routeConfig;

    /**
     * @var string
     */
    protected $pageBoardTemplate;

    /**
     * @param RouteConfig $routeConfig
     * @param array $blocks
     * @param $pageBoardTemplate
     */
    public function __construct(RouteConfig $routeConfig, array $blocks, $pageBoardTemplate)
    {
        $this->pageBlocks = $blocks;
        $this->routeConfig = $routeConfig;
        $this->pageBoardTemplate = $pageBoardTemplate;
    }

    /**
     * Get page-board blocks by route name
     *
     * @param $routeName
     * @throws \Exception
     * @throws \Suncat\AdminPageBoardBundle\Routing\Exception\NotFoundRouteNameException
     */
    public function getPageBlocksByRouteName($routeName)
    {
        $pageName = $this->routeConfig->getPageName($routeName);

        if (!isset($this->pageBlocks[$pageName])) {
            throw new \Exception(
                sprintf(
                    'Not found blocs for page with name \'%s\' and route name \'%s\'',
                    $pageName,
                    $routeName
                )
            );
        }

        return $this->pageBlocks[$pageName];
    }

    /**
     * Get page-board blocks by Request
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Suncat\AdminPageBoardBundle\Routing\Exception\NotFoundRouteNameException
     */
    public function getPageBlocksByRequest(Request $request)
    {
        $routeName = $request->get('_route');
        $pageName = $this->routeConfig->getPageName($routeName);

        if (!isset($this->pageBlocks[$pageName])) {
            throw new \Exception(
                sprintf(
                    'Not found blocs for page with name \'%s\' and route name \'%s\'',
                    $pageName,
                    $routeName
                )
            );
        }
        $blocks = $this->pageBlocks[$pageName];

        // add route_params to blocks
        foreach ($blocks as $index => $block) {
            $blocks[$index]['settings']['route_params'] = $request->get('_route_params');
        }

        return $blocks;
    }

    /**
     * Get page-board template
     * @return string
     */
    public function getTemplate()
    {
        return $this->pageBoardTemplate;
    }
} 