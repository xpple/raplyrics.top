<?php
$requestURI = $_SERVER['REQUEST_URI'];
$requestURI = trim($requestURI, '/');
$dirs = explode('/', $requestURI);
$dirCount = count($dirs);
if ($dirCount == 1) {
    require_once("../php/artists.php");
} elseif ($dirCount == 2) {
    $artistDirectory = $dirs[1];
    if ($artistDirectory == "index.php") {
        require_once("../php/artists.php");
    } else {
        require_once("../php/artist.php");
    }
} else {
    require_once("../php/unknown.php");
}
