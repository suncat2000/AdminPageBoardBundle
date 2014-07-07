<?php

namespace Suncat\AdminPageBoardBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteLoader
 *
 * @author Nikolay Ivlev <nikolay.kotovsky@gmail.com>
 */
class RouteLoader implements LoaderInterface
{
    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * @var \Suncat\AdminPageBoardBundle\Routing\RouteConfig
     */
    protected $routeConfig;

    /**
     * @var array
     */
    protected $defaults = array(
        '_controller' => 'SuncatAdminPageBoardBundle:Core:pageBoard',
    );

    /**
     * @param RouteConfig $routeConfig
     */
    public function __construct(RouteConfig $routeConfig)
    {
        $this->routeConfig = $routeConfig;
    }

    /**
     * @param $resource
     * @param null $type
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "admin_page_board" loader twice');
        }

        $routes = new RouteCollection();
        foreach ($this->routeConfig->getRouteConfigs() as $routeName => $routeConfig) {
            $this->parseRoute($routes, $routeName, $routeConfig);
        }

        $this->loaded = true;

        return $routes;
    }

    /**
     * @param $resource
     * @param null $type
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return 'sonata_admin_page_board' === $type;
    }

    /**
     *
     */
    public function getResolver()
    {
        // needed, but can be blank, unless you want to load other resources
        // and if you do, using the Loader base class is easier (see below)
    }

    /**
     * @param LoaderResolverInterface $resolver
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
        // same as above
    }

    /**
     * Parses a route and adds it to the RouteCollection.
     *
     * @param RouteCollection $collection A RouteCollection instance
     * @param string          $name       Route name
     * @param array           $config     Route definition
     * @param string          $path       Full path of the YAML file being processed
     */
    protected function parseRoute(RouteCollection $collection, $name, array $config)
    {
        $defaults = isset($config['defaults']) ? $config['defaults'] : $this->getRouteDefaults();
        $requirements = isset($config['requirements']) ? $config['requirements'] : array();
        $options = isset($config['options']) ? $config['options'] : array();
        $host = isset($config['host']) ? $config['host'] : '';
        $schemes = isset($config['schemes']) ? $config['schemes'] : array();
        $methods = isset($config['methods']) ? $config['methods'] : array();

        $route = new Route($config['path'], $defaults, $requirements, $options, $host, $schemes, $methods);

        $collection->add($name, $route);
    }

    /**
     * @return array
     */
    protected function getRouteDefaults()
    {
        return $this->defaults;
    }
} 