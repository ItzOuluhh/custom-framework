<?php

namespace Cloudstorage\Core;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];
    protected $middlewares = [];

    /**
     * Registreer een GET-route.
     *
     * @param string $uri
     * @param callable|array $action
     */
    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    /**
     * Registreer een POST-route.
     *
     * @param string $uri
     * @param callable|array $action
     */
    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    /**
     * Voeg een middleware toe aan de route.
     *
     * @param string $middleware
     */
    public function addMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Verwerk het inkomende verzoek en roep de juiste route aan.
     *
     * @param string $uri
     * @param string $method
     */
    public function dispatch($uri, $method)
    {
        $handler = function ($request) use ($uri, $method) {
            return $this->processRequest($uri, $method);
        };
        foreach (array_reverse($this->middlewares) as $middleware) {
            $handler = function ($request) use ($middleware, $handler) {
                return (new $middleware)->handle($request, $handler);
            };
        }

        return $handler($_REQUEST);
    }

    /**
     * Roep de juiste route aan.
     *
     * @param string $uri
     * @param string $method
     */
    private function processRequest($uri, $method)
    {
        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];

            if (is_callable($action)) {
                return call_user_func($action);
            } elseif (is_array($action) && isset($action[0], $action[1])) {
                $controller = $action[0];
                $method = $action[1];

                $request = new Request();
                $response = new Response();

                return call_user_func_array([new $controller(), $method], [$request, $response]);
            } else {
                throw new \Exception("Route action not valid.");
            }
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
