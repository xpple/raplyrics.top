<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once("./login-data.php");


try {
    $conn = new PDO("mysql:host=$server;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
} catch(PDOException $e) {
    die("Server error");
}

$isValidRequest = true;
if ($hasArtistId = array_key_exists("artistId", $_GET)) {
    $artistId = $_GET["artistId"];
    $statement = $conn->prepare("SELECT artist_name, artist_icon FROM artists WHERE HEX(artist_id) = :artist_id");
    $statement->execute(array("artist_id" => $artistId));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    if (count($result) == 1) {
        $row = $result[0];
        $artistName = $row["artist_name"];
        $artistIcon = $row["artist_icon"];
        $artistIconBase64 = base64_encode($artistIcon);
    } else {
        $isValidRequest = false;
    }

}
if ($hasSongId = array_key_exists("songId", $_GET)) {
    $songId = $_GET["songId"];
    $statement = $conn->prepare("SELECT song_title, HEX(songs.artist_id) as artist_id, artist_name, song_cover_image, song_description, song_lyrics FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE HEX(song_id) = :song_id");
    $statement->execute(array("song_id" => $songId));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    if (count($result) == 1) {
        $row = $result[0];
        $songTitle = $row["song_title"];
        $artistId = $row["artist_id"];
        $artistName = $row["artist_name"];
        $songCoverImage = $row["song_cover_image"];
        $songCoverImageBase64 = base64_encode($songCoverImage);
        $songDescription = $row["song_description"];
        $songLyrics = $row["song_lyrics"];
    } else {
        $isValidRequest = false;
    }
}
