<?php
$requestURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestURI = trim($requestURI, '/');
$dirs = explode('/', $requestURI);
$dirCount = count($dirs);
if ($dirCount == 1) {
    $searchQuery = "";
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/search.php");
} elseif ($dirCount == 2) {
    $searchQuery = $dirs[1];
    if ($searchQuery == "index.php") {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/php/unknown.php");
    } else {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/php/search.php");
    }
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/unknown.php");
}
