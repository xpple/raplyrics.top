<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once($_SERVER['DOCUMENT_ROOT'] . "../private/connect.php");


if (isset($artistId)) {
    $statement = $conn->prepare("SELECT HEX(artist_id) as artist_id, artist_name, artist_icon FROM artists WHERE HEX(artist_id) = :artist_id");
    $statement->execute(array("artist_id" => $artistId));
} elseif (isset($artistDirectory)) {
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
$artistName = htmlspecialchars($row["artist_name"]);
$artistIconBase64 = base64_encode($row["artist_icon"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $artistName ?> | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
    <link rel="stylesheet" href="/assets/style/header.css">
</head>
<body>
<header>
    <nav aria-label="breadcrumbs">
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/artists/">Artists</a></li>
            <li><a href="/artists/eminem/">Eminem</a></li>
        </ol>
    </nav>
    <nav aria-label="search component">
        <form role="search" id="search-form" method="post">
            <label for="search-input">Search</label>
            <input type="text" id="search-input" name="query" placeholder="Search for anything">
            <button type="submit">Search</button>
        </form>
    </nav>
</header>
<main>

</main>
<footer>
    [Footer]
</footer>
</body>
</html>
