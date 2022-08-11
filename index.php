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
    echo "Connected successfully";
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
    echo $artistName;
    echo "<img src='data:image/jpeg;base64,".base64_encode($artistIcon)."' alt='artist_icon'/>";
}
if ($hasSongId = array_key_exists("songId", $_GET)) {
    $songId = $_GET["songId"];
    $statement = $conn->prepare("SELECT song_title, artist_name, song_cover_image, song_lyrics FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE HEX(song_id) = :song_id");
    $statement->execute(array("song_id" => $songId));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result = $statement->fetchAll()[0];
    $songTitle = $result["song_title"];
    $artistName = $result["artist_name"];
    $songCoverImage = $result["song_cover_image"];
    $songLyrics = $result["song_lyrics"];
    echo $songTitle;
    echo $artistName;
    echo "<img src='data:image/jpeg;base64,".base64_encode($songCoverImage)."' alt='song_cover_image'/>";
    echo $songLyrics;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rap Lyrics Top</title>
</head>
<body>
Content Coming Soon. As a preview, check out <a href="/eminem/good-guy/">Good Guy by Eminem</a>.
</body>
</html>
