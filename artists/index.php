<?php
$requestURI = $_SERVER['REQUEST_URI'];
$requestURI = trim($requestURI, '/');
$dirs = explode('/', $requestURI);
$dirCount = count($dirs);
if ($dirCount == 1) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/artists.php");
} elseif ($dirCount == 2) {
    $artistDirectory = $dirs[1];
    if ($artistDirectory == "index.php") {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/php/artists.php");
    } else {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/php/artist.php");
    }
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/unknown.php");
}

