<?php
if ($artistId = $_GET["artistId"] ?? null) {
    require_once("./php/artist.php");
} elseif ($songId = $_GET["songId"] ?? null) {
    require_once("./php/song.php");
} else {
    require_once("./php/home.php");
}
