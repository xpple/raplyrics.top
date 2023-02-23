<?php

namespace App;


spl_autoload_register(static function ($class) {
    static $root;
    if ($root == null) {
        $root = dirname($_SERVER['DOCUMENT_ROOT']);
    }
    $parts = explode('\\', $class);
    $filename = array_pop($parts);
    $parts = strtolower(implode('/', $parts));
    $filePath = $root . '/' . $parts . '/' . $filename . '.php';
    if (is_file($filePath)) {
        require $filePath;
    }
});

use App\Controllers\ErrorController;
use App\Controllers\IndexController;
use Exception;

try {
    $requestURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (str_ends_with($requestURI, "index.php")) {
        $requestURI = mb_substr($requestURI, 0, -9);
        $requestURI = ltrim($requestURI, '/');
    } else {
        $requestURI = trim($requestURI, '/');
    }
    $controller = new IndexController(array_filter(explode('/', $requestURI)));
    $controller->load();
} catch (Exception $e) {
    $controller = new ErrorController();
    $controller->setCause($e);
    $controller->load();
}
