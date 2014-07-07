<?php

namespace Suncat\AdminPageBoardBundle\Routing;

use Suncat\AdminPageBoardBundle\Routing\Exception\NotFoundRouteNameException;

/**
 * Class RouteConfig
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class RouteConfig
{
    /**
     * @var string
     */
    protected $routesPrefixName;

    /**
     * @var array
     */
    protected $routeConfigs;

    /**
     * @var array
     */
    protected $routePageMap;

    /**
     * @param array $routesConfig
     * @param string $routesPrefixName
     */
    public function __construct(array $routesConfig, $routesPrefixName = 'sonata_admin_page_board')
    {
        $this->routesPrefixName = $routesPrefixName;

        foreach ($routesConfig as $pageName => $routeConfig) {
            $routeName = $routeConfig['name'];
            if (null === $routeName) {
                $routeName = $this->generateRouteName($pageName);
            }

            $this->routePageMap[$routeName] = $pageName;
            $this->routeConfigs[$routeName] = $routeConfig;
        }
    }

    /**
     * Get page board name by route name
     *
     * @param $routeName
     * @return null|string
     */
    public function getPageName($routeName)
    {
        if (isset($this->routePageMap[$routeName])) {
            return $this->routePageMap[$routeName];
        }

        throw new NotFoundRouteNameException(sprintf('Not found route with name \'%s\'', $routeName));
    }

    /**
     * Get route configs
     *
     * @return array
     */
    public function getRouteConfigs()
    {
        return $this->routeConfigs;
    }

    /**
     * Generate route name by page-board name
     *
     * @param $pageName
     * @return string
     */
    public function generateRouteName($pageName)
    {
        return rtrim($this->routesPrefixName, '_') . '_' . $this->tableize($pageName);
    }

    /**
     * @param $word
     * @return string
     */
    protected static function tableize($word)
    {
        return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', $word));
    }
} 