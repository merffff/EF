<?php

class Router {
    private $routes = [];

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

        foreach ($this->routes as $route) {
            if ($route['path'] === $requestPath && $route['method'] === $_SERVER['REQUEST_METHOD']) {
                $this->callAction($route['controller'], $route['action']);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Маршрут не найден. Искали: {$requestPath}";
    }

    private function callAction($controllerName, $actionName) {
        $controllerFile = "controllers/{$controllerName}.php";

        if (!file_exists($controllerFile)) {
            throw new Exception("Контроллер {$controllerName} не найден");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            throw new Exception("Класс {$controllerName} не существует");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $actionName)) {
            throw new Exception("Метод {$actionName} не найден в {$controllerName}");
        }

        $controller->$actionName();
    }
    public function getRoutes() {
        return $this->routes;
    }
}


$GLOBALS['router'] = new Router();

function route($method, $path, $controller, $action) {
    $GLOBALS['router']->addRoute($method, $path, $controller, $action);
}
