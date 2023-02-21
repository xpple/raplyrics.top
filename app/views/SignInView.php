<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
    <link rel="stylesheet" href="/assets/style/header.css">
    <link rel="stylesheet" href="/assets/style/fieldset.css">
    <link rel="stylesheet" href="/assets/style/sign-in/body.css">
    <script src="/assets/script/search.js" type="module" async></script>
</head>
<body>
<header>
    <nav aria-label="breadcrumbs">
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/sign-in/">Sign In</a></li>
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
    <div id="form-container">
        <form action="" method="post">
            <fieldset>
                <legend>Sign Up</legend>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="john.smith@example.com">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <button type="submit">Sign Up</button>
            </fieldset>
        </form>
    </div>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>
