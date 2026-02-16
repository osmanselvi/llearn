<?php
session_start();

/**
 * Front Controller
 * English LMS Project
 */

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Composer Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Autoload (Simple version for now)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Basic Router
$url = $_GET['url'] ?? '/';
$url = rtrim($url, '/');
$parts = explode('/', $url);

$controllerName = !empty($parts[0]) ? ucfirst($parts[0]) . 'Controller' : 'HomeController';
$methodName = !empty($parts[1]) ? $parts[1] : 'index';
$params = array_slice($parts, 2);

$controllerClass = "App\\Controllers\\" . $controllerName;

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        http_response_code(404);
        echo "404 - Method '$methodName' not found in $controllerName";
    }
} else {
    // Default to Home if root
    if ($url == '' || $url == '/') {
        $controller = new \App\Controllers\HomeController();
        $controller->index();
    } else {
        http_response_code(404);
        echo "404 - Controller '$controllerClass' not found";
    }
}
