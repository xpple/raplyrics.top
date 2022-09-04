<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
    <link rel="stylesheet" href="/assets/style/header.css">
    <link rel="stylesheet" href="/assets/style/fieldset.css">
    <link rel="stylesheet" href="/assets/style/sign-up/body.css">
    <script src="/assets/script/search.js" type="module" async></script>
    <script src="/assets/script/validate-form.js" type="module"></script>
</head>
<body>
<header>
    <nav aria-label="breadcrumbs">
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/sign-up/">Sign Up</a></li>
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

        <?php
        session_start();
        if ($username = $_SESSION["username"] ?? false) {
            echo(<<<HTML
                <div id="username" class="user">
                    Welcome, $username
                </div>
                <div id="account" class="user">
                    Account
                </div>
                HTML);
        } else {
            echo(<<<HTML
                <div id="sign-up" class="login">
                    <a href="/sign-up/">Sign Up</a>
                </div>
                <div id="sign-in" class="login">
                    <a href="/sign-in/">Sign In</a>
                </div>
                HTML);
        }
        ?>
    </div>
</header>
<main>
    <div id="form-container">
        <form id="sign-up-form" action="/sign-up/" method="post" novalidate>
            <fieldset>
                <legend>Sign Up</legend>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="john.smith@example.com" required aria-required="true">
                <small class="error-message"></small>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" minlength="3" maxlength="30" required aria-required="true">
                <small class="error-message"></small>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" minlength="10" required aria-required="true">
                <small class="error-message"></small>
                <label for="confirm">Confirm password:</label>
                <input type="password" id="confirm" name="confirm" required aria-required="true">
                <small class="error-message"></small>
                <button type="submit">Sign Up</button>
            </fieldset>
        </form>
        <p id="error"><?= $this->errorMessage ?></p>
    </div>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>
