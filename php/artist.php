<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once($_SERVER['DOCUMENT_ROOT'] . "/php/connect.php");


if ($artistId) {
    $statement = $conn->prepare("SELECT HEX(artist_id) as artist_id, artist_name, artist_icon FROM artists WHERE HEX(artist_id) = :artist_id");
    $statement->execute(array("artist_id" => $artistId));
} elseif ($artistDirectory) {
    $statement = $conn->prepare("SELECT HEX(artist_id) as artist_id, artist_name, artist_icon FROM artists WHERE artist_directory = :artist_directory");
    $statement->execute(array("artist_directory" => $artistDirectory));
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/unknown.php");
    exit();
}

$statement->setFetchMode(PDO::FETCH_ASSOC);
$result = $statement->fetchAll();
if (count($result) != 1) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/unknown.php");
    exit();
}
$row = $result[0];
$artistId = $row["artist_id"];
$artistName = $row["artist_name"];
$artistIcon = $row["artist_icon"];
$artistIconBase64 = base64_encode($artistIcon);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $artistName ?> | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
</head>
<body>
<header>
    <nav>
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/artists/">Artists</a></li>
            <li><a href="/artists/<?= $artistDirectory ?>/"></a><?= $artistName ?></li>
        </ol>
    </nav>
</header>
<main></main>
<footer></footer>
</body>
</html>
