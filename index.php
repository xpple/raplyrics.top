<?php
require_once("./php/connect.php");


if ($isValidRequest) {
    if ($hasSongId) {
        require_once("./php/song.php");
    } elseif ($hasArtistId) {
        require_once("./php/artist.php");
    } else {
        require_once("./php/home.php");
    }
} else {
    require_once("./php/unknown.php");
}
