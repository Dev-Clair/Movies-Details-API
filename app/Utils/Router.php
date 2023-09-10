<?php

declare(strict_types=1);

namespace app\Utils;

use app\Exception\RouteNotFoundException;

class Router
{
    private array $routes;

    public function register(string $requestMethod, string $route, array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, array $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve()
    {
        $requestMethod = strtolower(string: $_SERVER['REQUEST_METHOD']);
        $requestUri = parse_url(url: $_SERVER['REQUEST_URI'], component: PHP_URL_PATH);

        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (is_array(value: $action)) {
            [$class, $method] =  $action;

            if (class_exists(class: $class)) {
                $class = new $class;
            }

            if (method_exists($class, $method)) {
                $result = call_user_func_array(callback: [$class, $method], args: []);
                return $result;
            }
        }
        throw new RouteNotFoundException();
    }
}
