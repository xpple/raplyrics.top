<?php
$requestURI = $_SERVER['REQUEST_URI'];
$requestURI = trim($requestURI, '/');
$dirs = explode('/', $requestURI);
$dirCount = count($dirs);
if ($dirCount == 1) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "./php/songs.php");
} elseif ($dirCount == 2) {
    $artistDirectory = $dirs[1];
    if ($artistDirectory == "index.php") {
        require_once($_SERVER['DOCUMENT_ROOT'] . "./php/songs.php");
    } else {
        header("Location: https://raplyrics.top/artists/$artistDirectory/", true, 301);
    }
} elseif ($dirCount == 3) {
    $artistDirectory = $dirs[1];
    $songDirectory = $dirs[2];
    require_once($_SERVER['DOCUMENT_ROOT'] . "./php/song.php");
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "./php/unknown.php");
}
