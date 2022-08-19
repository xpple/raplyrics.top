<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once($_SERVER['DOCUMENT_ROOT'] . "/php/connect.php");

if (isset($searchQuery)) {
    $conn->prepare("SELECT HEX(artist_id) as artist_id, artist_name, artist_icon, artist_directory FROM artists WHERE INSTR(artist_name, :search_query) > 0");
    $statement->execute(array("search_query" => $searchQuery));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $artistResults = $statement->fetchAll();
    $conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE INSTR(song_title, :search_query) > 0");
    $statement->execute(array("search_query" => $searchQuery));
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $songResults = $statement->fetchAll();
    $conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE CHAR_LENGTH(:search_query) > 10 AND INSTR(song_lyrics, :search_query) > 0");
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
    <h1>Search results for "<?= $searchQuery ?>"</h1>
    <div id="results-container">
        <section id="artist-results" class="results">
            <h2>Artists</h2>
            <div class="card-container">
                <?php
                foreach ($artistResults as $artistResult) {
                    $artistName = $artistResult["artist_name"];
                    $artistIcon = $artistResult["artist_icon"];
                    $artistIconBase64 = base64_encode($artistIcon);
                    $artistDirectory = $artistResult["artist_directory"];
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
                    $songTitle = $songResult["song_title"];
                    $artistName = $songResult["artist_name"];
                    $artistDirectory = $songResult["artist_directory"];
                    $songCoverImage = $songResult["song_cover_image"];
                    $songCoverImageBase64 = base64_encode($songCoverImage);
                    $songDescription = $songResult["song_description"];
                    $songDirectory = $songResult["song_directory"];
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
                    $songTitle = $lyricResult["song_title"];
                    $artistName = $lyricResult["artist_name"];
                    $artistDirectory = $lyricResult["artist_directory"];
                    $songCoverImage = $lyricResult["song_cover_image"];
                    $songCoverImageBase64 = base64_encode($songCoverImage);
                    $songDescription = $lyricResult["song_description"];
                    $songDirectory = $lyricResult["song_directory"];
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
