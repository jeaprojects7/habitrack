<?php

class Router {
    private $routes;
    private $modulePaths;
    private $currentRoute;
    private $userRole;

    public function __construct() {
        $this->routes = include "configs/routes.php";
        $this->modulePaths = include "configs/modulePaths.php";
        $this->userRole = $_SESSION['role'] ?? null;
    }

    public function getRoute() {
        // Get the route from URL or GET parameter
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $basePath = '/habitrack';
        
        // Remove base path and query string
        $path = str_replace($basePath, '', parse_url($requestUri, PHP_URL_PATH));
        $path = trim($path, '/');
        
        // If empty, check GET parameter or default
        if (empty($path)) {
            return $_GET['route'] ?? null;
        }
        
        return $path;
    }

    public function isAllowedRoute($route) {
        // Public routes (not logged in)
        $publicRoutes = [
            'start',
            'clientlogin',
            'agentlogin',
            'adminlogin',
            'clientsignup',
            'home',
        ];

        // Check if user is logged in
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "ok") {
            $allowedRoutes = $this->routes[$this->userRole] ?? [];
            return in_array($route, $allowedRoutes);
        }

        // Not logged in - only public routes allowed
        return in_array($route, $publicRoutes);
    }

    public function getModulePath($route) {
        return $this->modulePaths[$route] ?? null;
    }

    public function render($route) {
        // Sanitize route
        $route = basename($route);

        // Check if route exists
        if (!isset($this->modulePaths[$route])) {
            return 'modules/404.php';
        }

        // Check permissions
        if (!$this->isAllowedRoute($route)) {
            return 'modules/403.php';
        }

        return $this->modulePaths[$route];
    }
}

?>
