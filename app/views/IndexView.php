<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/public/assets/style/main.css">
    <link rel="stylesheet" href="/public/assets/style/header.css">
    <link rel="stylesheet" href="/public/assets/style/index/body.css">
    <script src="/public/assets/script/search.js" type="module" async></script>
</head>
<body>
<header>
    <nav aria-label="breadcrumbs">
        <ol>
            <li><a href="/">Home</a></li>
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
    <section id="search">
        <h2>Browse what's popular</h2>
        <nav aria-label="main search component">
            <form role="search" id="search-form" method="get">
                <label for="search-input">Search</label>
                <input type="text" id="search-input" name="query" placeholder="Search for anything">
                <button type="submit">Search</button>
            </form>
        </nav>
    </section>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>
