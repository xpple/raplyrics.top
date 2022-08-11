<?php
extract(file("login_data.txt", FILE_IGNORE_NEW_LINES), EXTR_PREFIX_ALL, "loginData");
$server = $loginData_0;
$port = $loginData_1;
$user = $loginData_2;
$pass = $loginData_3;
$dbname = $loginData_4;

try {
    $conn = new PDO("mysql:host=$server;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Server error");
}

if ($hasArtistId = array_key_exists("artistId", $_GET)) {
    $artistId = $_GET["artistId"];
    $statement = $conn->prepare("SELECT artist_name, artist_icon FROM artists WHERE HEX(artist_id) = :artist_id");
    $statement->execute(array("artist_id" => $artistId));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result = $statement->fetchAll()[0];
    $artistName = $result["artist_name"];
    $artistIcon = $result["artist_icon"];
}
if ($hasSongId = array_key_exists("songId", $_GET)) {
    $songId = $_GET["songId"];
    $statement = $conn->prepare("SELECT song_title, HEX(songs.artist_id), artist_name, song_cover_image, song_lyrics FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE HEX(song_id) = :song_id");
    $statement->execute(array("song_id" => $songId));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result = $statement->fetchAll()[0];
    $songTitle = $result["song_title"];
    $artistId = $result["artist_id"];
    $artistName = $result["artist_name"];
    $songCoverImage = $result["song_cover_image"];
    $songCoverImageBase64 = base64_encode($songCoverImage);
    $songLyrics = $result["song_lyrics"];
}
if ($hasSongId) {
    echo(<<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>$artistName - $songTitle | Rap Lyrics Top</title>

    <link rel="stylesheet" href="./assets/style/main.css">
    <link rel="stylesheet" href="./assets/style/lyrics.css">
    <script src="./assets/script/module.js" type="module" async></script>
</head>
<body>
<header>
    <nav>
        <ol>
            <li><a href="./">Home</a></li>
            <li><a href="?artistId=$artistId">$artistName</a></li>
            <li><a href="?songId=$songId">$songTitle</a></li>
        </ol>
    </nav>
</header>
<main>
    <section id="song-info">
        <div id="img-container">
            <img src="data:image/jpeg;base64,$songCoverImageBase64" alt="$songTitle by $artistName"/>
        </div>
        <div id="about">
            <h1>$songTitle</h1>
            <h2>$artistName</h2>
            <p>Song description</p>
        </div>
    </section>
    <section id="lyrics">
        <h1>Lyrics</h1>
        $songLyrics
    </section>
    <section id="annotation">
    </section>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>

HTML);
}
