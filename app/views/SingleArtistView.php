<?php
extract(get_object_vars($this->artist));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($artistName) ?> | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
    <link rel="stylesheet" href="/assets/style/header.css">
    <script src="/assets/script/search.js" type="module" async></script>
</head>
<body>
<header>
    <nav aria-label="breadcrumbs">
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/artists/">Artists</a></li>
            <li><a href="/artists/<?= htmlspecialchars($artistDirectory) ?>/"><?= htmlspecialchars($artistName) ?></a></li>
        </ol>
    </nav>
    <nav aria-label="search component">
        <form role="search" id="search-form" method="get">
            <label for="search-input">Search</label>
            <input type="text" id="search-input" name="query" placeholder="Search for anything">
            <button type="submit">Search</button>
        </form>
    </nav>
</header>
<main>
    <section id="artist-info">
        <div id="img-container">
            <img src="data:image/jpeg;base64,<?= $songCoverImageBase64 ?>" alt="<?= htmlspecialchars($songTitle) ?> by <?= htmlspecialchars($artistName) ?>" width="300px" height="300px">
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
