<?php
use App\Models\ArtistModel;
/* @var $artist ArtistModel */
$artist = $this->artist;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($artist->artistName) ?> | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/public/assets/style/main.css">
    <link rel="stylesheet" href="/public/assets/style/header.css">
    <script src="/public/assets/script/search.js" type="module" async></script>
</head>
<body>
<header>
    <nav aria-label="breadcrumbs">
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/artists/">Artists</a></li>
            <li><a href="/artists/<?= htmlspecialchars($artist->artistDirectory) ?>/"><?= htmlspecialchars($artist->artistName) ?></a></li>
        </ol>
    </nav>
    <div class="last-child">
        <nav aria-label="search component">
            <form role="search" id="search-form" method="get">
                <label for="search-input">Search</label>
                <input type="text" id="search-input" name="query" placeholder="Search for anything">
                <button type="submit">Search</button>
            </form>
        </nav>

        <div id="sign-up" class="login">
            <a href="/sign-up/">Sign Up</a>
        </div>
        <div id="sign-in" class="login">
            <a href="/sign-in/">Sign In</a>
        </div>
    </div>
</header>
<main>
    <section id="artist-info">
        <div id="img-container">
        </div>
    </section>
    <section id="songs">

    </section>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>
