<?php
require("./php/connect.php");


if ($isValidRequest) {
    if ($hasSongId) {
        require("./php/song.php");
    } elseif ($hasArtistId) {
        require("./php/artist.php");
    } else {
        require("./php/home.php");
    }
} else {
    require("./php/unknown.php");
}
