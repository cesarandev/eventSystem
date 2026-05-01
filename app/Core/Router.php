<?php
declare(strict_types=1);

namespace App\Core;

use Throwable;

final class Router
{
    private array $routes = [];

    public function get(string $path, string $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, string $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch(string $method, string $path): void
    {
        $path = rtrim($path, '/') ?: '/';
        $action = $this->routes[$method][$path] ?? null;

        if ($action === null) {
            http_response_code(404);
            $viewPath = BASE_PATH . '/app/Views/errors/404.php';
            require BASE_PATH . '/app/Views/layouts/main.php';
            return;
        }

        [$controller, $methodName] = explode('@', $action);
        $controllerClass = 'App\\Controllers\\' . $controller;

        try {
            (new $controllerClass())->{$methodName}();
        } catch (Throwable $throwable) {
            http_response_code(500);
            $errorMessage = $throwable->getMessage();
            $viewPath = BASE_PATH . '/app/Views/errors/500.php';
            require BASE_PATH . '/app/Views/layouts/main.php';
        }
    }
}
