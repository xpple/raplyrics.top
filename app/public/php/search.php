<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once($_SERVER['DOCUMENT_ROOT'] . "../private/connect.php");

if (isset($searchQuery)) {
    $searchQuery = rawurldecode($searchQuery);
    $statement = $conn->prepare("SELECT HEX(artist_id) as artist_id, artist_name, artist_icon, artist_directory FROM artists WHERE INSTR(artist_name, :search_query) > 0");
    $statement->execute(array("search_query" => $searchQuery));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $artistResults = $statement->fetchAll();
    $statement = $conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE INSTR(song_title, :search_query) > 0");
    $statement->execute(array("search_query" => $searchQuery));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $songResults = $statement->fetchAll();
    $statement = $conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE CHAR_LENGTH(:search_query) > 10 AND INSTR(song_lyrics, :search_query) > 0");
    $statement->execute(array("search_query" => $searchQuery));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $lyricResults = $statement->fetchAll();
} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/unknown.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
    <link rel="stylesheet" href="/assets/style/search/search-bar.css">
    <link rel="stylesheet" href="/assets/style/search/results.css">
    <script src="/assets/script/search.js" type="module" async></script>
</head>
<body>
<header>
    <nav aria-label="search component">
        <form role="search" id="search-form" method="post">
            <label for="search-input">Search</label>
            <input type="text" id="search-input" name="query" placeholder="Search for anything">
            <button type="submit">Search</button>
        </form>
    </nav>
</header>
<main>
    <h1>Search results for "<?= htmlspecialchars(rawurldecode($searchQuery)) ?>"</h1>
    <div id="results-container">
        <section id="artist-results" class="results">
            <h2>Artists</h2>
            <div class="card-container">
                <?php
                foreach ($artistResults as $artistResult) {
                    $artistName = htmlspecialchars($artistResult["artist_name"]);
                    $artistIconBase64 = base64_encode($artistResult["artist_icon"]);
                    $artistDirectory = htmlspecialchars($artistResult["artist_directory"]); // technically not needed
                    echo(<<<HTML
                        <a href="/artists/$artistDirectory/" class="result-card">
                            <figure>
                                <figcaption>$artistName</figcaption>
                                <img src="data:image/jpeg;base64,$artistIconBase64" alt="Artist icon of $artistName">
                            </figure>
                        </a>
                        HTML);
                }
                ?>
            </div>
        </section>
        <section id="song-results" class="results">
            <h2>Songs</h2>
            <div class="card-container">
                <?php
                foreach ($songResults as $songResult) {
                    $songTitle = htmlspecialchars($songResult["song_title"]);
                    $artistName = htmlspecialchars($songResult["artist_name"]);
                    $artistDirectory = htmlspecialchars($songResult["artist_directory"]);
                    $songCoverImageBase64 = base64_encode($songResult["song_cover_image"]);
                    $songDescription = htmlspecialchars($songResult["song_description"]);
                    $songDirectory = htmlspecialchars($songResult["song_directory"]);
                    echo(<<<HTML
                        <a href="/songs/$artistDirectory/$songDirectory/" class="result-card">
                            <figure>
                                <figcaption>$songTitle</figcaption>
                                <img src="data:image/jpeg;base64,$songCoverImageBase64" alt="$songTitle by $artistName">
                            </figure>
                            <span>$songDescription</span>
                        </a>
                        HTML);
                }
                ?>
            </div>
        </section>
        <section id="lyric-results" class="results">
            <h2>Lyrics</h2>
            <div class="card-container">
                <?php
                foreach ($lyricResults as $lyricResult) {
                    $songTitle = htmlspecialchars($lyricResult["song_title"]);
                    $artistName = htmlspecialchars($lyricResult["artist_name"]);
                    $artistDirectory = htmlspecialchars($lyricResult["artist_directory"]);
                    $songCoverImageBase64 = base64_encode($lyricResult["song_cover_image"]);
                    $songDescription = htmlspecialchars($lyricResult["song_description"]);
                    $songDirectory = htmlspecialchars($lyricResult["song_directory"]);
                    echo(<<<HTML
                        <a href="/songs/$artistDirectory/$songDirectory/" class="result-card">
                            <figure>
                                <figcaption>$songTitle</figcaption>
                                <img src="data:image/jpeg;base64,$songCoverImageBase64" alt="$songTitle by $artistName">
                            </figure>
                            <span>$songDescription</span>
                        </a>
                        HTML);
                }
                ?>
            </div>
        </section>
    </div>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>
