<?php


use Psr\Container\ContainerInterface;

class Router {
    private $routes = [];
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function handleRequest() {
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestPath = rtrim($requestPath, '/') ?: '/';
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($this->matchRoute($route, $requestPath, $requestMethod)) {
                $this->callAction($route['controller'], $route['action']);
                return;
            }
        }

        $this->handleNotFound($requestPath);
    }

    private function matchRoute(array $route, string $path, string $method): bool {
        return $route['path'] === $path && $route['method'] === $method;
    }

    private function callAction(string $controllerName, string $actionName) {
        try {
            $controller = $this->container->get($controllerName);

            if (!method_exists($controller, $actionName)) {
                throw new Exception("Метод {$actionName} не найден в {$controllerName}");
            }

            $controller->$actionName();
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    private function handleNotFound(string $path) {
        http_response_code(404);
        echo "404 - Маршрут не найден. Искали: {$path}";
    }

    private function handleError(Exception $e) {
        http_response_code(500);
        echo "500 - Ошибка сервера: " . $e->getMessage();
        error_log($e->getMessage());
    }

    public function getRoutes(): array {
        return $this->routes;
    }
}