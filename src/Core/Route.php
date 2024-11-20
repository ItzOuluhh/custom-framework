<?php

namespace Cloudstorage\Core;

class Route
{
    protected static $router;

    /**
     * Stel de router in die gebruikt wordt voor route-aanroepen.
     *
     * @param Router $router
     */
    public static function setRouter(Router $router)
    {
        self::$router = $router;
    }

    /**
     * Registreer een GET-route.
     *
     * @param string $uri
     * @param callable|array $action
     */
    public static function get($uri, $action)
    {
        self::$router->get($uri, $action);
    }

    /**
     * Registreer een POST-route.
     *
     * @param string $uri
     * @param callable|array $action
     */
    public static function post($uri, $action)
    {
        self::$router->post($uri, $action);
    }

    /**
     * Voeg een middleware toe aan de route.
     *
     * @param string $middleware
     */
    public static function middleware($middleware)
    {
        self::$router->addMiddleware($middleware);
    }
}
