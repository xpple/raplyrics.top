<?php
require("./php/connect.php");


if ($hasSongId and $isValidRequest) {
    require("./php/song.php");
} elseif ($hasArtistId and $isValidRequest) {
    require("./php/artist.php");
}
