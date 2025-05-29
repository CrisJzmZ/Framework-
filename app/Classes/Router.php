<?php
class Router {
    private $routes = [];
    
    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    public function dispatch($method, $uri) {
        // Limpiar y normalizar la URI
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');
        
        // Debug: mostrar la URI que se está procesando en desarrollo
        if (function_exists('config') && config('app.environment') === 'development') {
            echo "<!-- Router: Processing URI: '$uri' with method: $method -->\n";
        }
        
        // Buscar coincidencia exacta primero
        foreach ($this->routes as $route) {
            if (function_exists('config') && config('app.environment') === 'development') {
                echo "<!-- Router: Checking route: {$route['method']} '{$route['path']}' -->\n";
            }
            
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri)) {
                if (function_exists('config') && config('app.environment') === 'development') {
                    echo "<!-- Router: MATCH FOUND! Executing {$route['controller']}::{$route['action']} -->\n";
                }
                return $this->executeRoute($route);
            }
        }
        
        // Si no se encuentra ruta, mostrar 404
        if (function_exists('config') && config('app.environment') === 'development') {
            echo "<!-- Router: NO MATCH FOUND - Showing 404 -->\n";
        }
        return $this->show404();
    }
    
    private function matchPath($routePath, $uri) {
        // Normalizar ambas rutas
        $routePath = trim($routePath, '/');
        $uri = trim($uri, '/');
        
        // Debug
        if (function_exists('config') && config('app.environment') === 'development') {
            echo "<!-- Router: Comparing '$routePath' with '$uri' -->\n";
        }
        
        // Manejar ruta raíz
        if ($routePath === '' && $uri === '') {
            if (function_exists('config') && config('app.environment') === 'development') {
                echo "<!-- Router: ROOT ROUTE MATCH -->\n";
            }
            return true;
        }
        
        // Comparación exacta
        $match = $routePath === $uri;
        if (function_exists('config') && config('app.environment') === 'development') {
            echo "<!-- Router: Exact match result: " . ($match ? 'TRUE' : 'FALSE') . " -->\n";
        }
        return $match;
    }
    
    private function executeRoute($route) {
        $controllerName = $route['controller'];
        $actionName = $route['action'];
        
        if (function_exists('config') && config('app.environment') === 'development') {
            echo "<!-- Router: Executing $controllerName::$actionName -->\n";
        }
        
        try {
            if (!class_exists($controllerName)) {
                throw new Exception("Controller '$controllerName' not found");
            }
            
            $controller = new $controllerName();
            
            if (!method_exists($controller, $actionName)) {
                throw new Exception("Method '$actionName' not found in controller '$controllerName'");
            }
            
            if (function_exists('config') && config('app.environment') === 'development') {
                echo "<!-- Router: Successfully created controller and calling method -->\n";
            }
            
            return $controller->$actionName();
            
        } catch (Exception $e) {
            if (function_exists('config') && config('app.environment') === 'development') {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; margin: 10px; border: 1px solid #f5c6cb; border-radius: 4px;'>";
                echo "<h3>Router Error</h3>";
                echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
                echo "<p><strong>Controller:</strong> $controllerName</p>";
                echo "<p><strong>Action:</strong> $actionName</p>";
                echo "</div>";
            }
            return $this->show404();
        }
    }
    
    private function show404() {
        if (function_exists('config') && config('app.environment') === 'development') {
            echo "<!-- Router: Showing 404 error -->\n";
        }
        
        if (class_exists('ErrorController')) {
            $errorController = new ErrorController();
            return $errorController->notFound();
        } else {
            http_response_code(404);
            echo "<h1>404 - Página no encontrada</h1>";
        }
    }
}
