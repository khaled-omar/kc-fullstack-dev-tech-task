<?php

namespace Libs;

class Router
{
    private $routes = [];

    public function get($route, $action)
    {
        $this->routes['GET'][$route] = $action;
    }

    public function dispatch($uri, $method)
    {
        // Parse the URL and separate the path and query string
        $parsedUrl = parse_url($uri);
        $path = trim($parsedUrl['path'], '/');

        // Extract query parameters (if any)
        parse_str($parsedUrl['query'] ?? '', $queryParams);

        foreach ($this->routes[$method] as $route => $action) {
            // Convert route pattern to regular expression (for dynamic segments)
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9-]+)', trim($route, '/'));
            $pattern = "#^" . $pattern . "$#";

            // Check if the current URI matches the pattern
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);  // Remove the full match from the array

                // Pass query parameters and dynamic route parameters to the controller
                call_user_func_array($action, array_merge($matches, [$queryParams]));
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["message" => "Route not found"]);
    }
}
