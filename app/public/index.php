<?php
if ($artistId = $_GET["artistId"] ?? null) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/artist.php");
} elseif ($songId = $_GET["songId"] ?? null) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/song.php");
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/home.php");
}
