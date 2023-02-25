<?php
use App\Models\SearchResultsModel;
/* @var $searchResults SearchResultsModel */
$searchResults = $this->searchResults
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/public/assets/style/main.css">
    <link rel="stylesheet" href="/public/assets/style/search/search-bar.css">
    <link rel="stylesheet" href="/public/assets/style/search/results.css">
    <script src="/public/assets/script/search.js" type="module" async></script>
</head>
<body>
<header>
    <nav aria-label="search component">
        <form role="search" id="search-form" method="get">
            <label for="search-input">Search</label>
            <input type="text" id="search-input" name="query" placeholder="Search for anything">
            <button type="submit">Search</button>
        </form>
    </nav>
</header>
<main>
    <h1>
        <?php
        if (isset($this->searchQuery)) {
            echo "Search results for \"" . htmlspecialchars(rawurldecode($this->searchQuery)) . "\"";
        } else {
            echo "No search results";
        }
        ?>
    </h1>
    <div id="results-container">
        <section id="artist-results" class="results">
            <h2>Artists</h2>
            <div class="card-container">
                <?php
                foreach ($searchResults->artistResults as $artist) {
                    $artistName = htmlspecialchars($artist->artistName);
                    $artistIconBase64 = base64_encode($artist->artistIcon);
                    $artistDirectory = htmlspecialchars($artist->artistDirectory);
                    echo(<<<HTML
                        <a href="/artists/{$artistDirectory}/" class="result-card">
                            <figure>
                                <figcaption>{$artistName}</figcaption>
                                <img src="data:image/jpeg;base64,{$artistIconBase64}" alt="Artist icon of {$artistName}">
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
                foreach ($searchResults->songResults as $song) {
                    $songTitle = htmlspecialchars($song->songTitle);
                    $artistName = htmlspecialchars($song->artistName);
                    $artistDirectory = htmlspecialchars($song->artistDirectory);
                    $songCoverImageBase64 = base64_encode($song->songCoverImage);
                    $songDescription = htmlspecialchars($song->songDescription);
                    $songDirectory = htmlspecialchars($song->songDirectory);
                    echo(<<<HTML
                        <a href="/songs/{$artistDirectory}/{$songDirectory}/" class="result-card">
                            <figure>
                                <figcaption>{$songTitle}</figcaption>
                                <img src="data:image/jpeg;base64,{$songCoverImageBase64}" alt="{$songTitle} by {$artistName}">
                            </figure>
                            <span>{$songDescription}</span>
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
                foreach ($searchResults->lyricResults as $lyrics) {
                    $songTitle = htmlspecialchars($lyrics->songTitle);
                    $artistName = htmlspecialchars($lyrics->artistName);
                    $artistDirectory = htmlspecialchars($lyrics->artistDirectory);
                    $songCoverImageBase64 = base64_encode($lyrics->songCoverImage);
                    $songDescription = htmlspecialchars($lyrics->songDescription);
                    $songDirectory = htmlspecialchars($lyrics->songDirectory);
                    echo(<<<HTML
                        <a href="/songs/{$artistDirectory}/{$songDirectory}/" class="result-card">
                            <figure>
                                <figcaption>{$songTitle}</figcaption>
                                <img src="data:image/jpeg;base64,{$songCoverImageBase64}" alt="{$songTitle} by {$artistName}">
                            </figure>
                            <span>{$songDescription}</span>
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
