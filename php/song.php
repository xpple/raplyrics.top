<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require("./connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $artistName ?> - <?php echo $songTitle ?> | Rap Lyrics Top</title>

    <link rel="stylesheet" href="../assets/style/main.css">
    <link rel="stylesheet" href="../assets/style/lyrics.css">
    <script src="../assets/script/module.js" type="module" async></script>
</head>
<body>
<header>
    <nav>
        <ol>
            <li><a href="./">Home</a></li>
            <li><a href="?artistId=<?php echo $artistId?>"><?php echo $artistName ?></a></li>
            <li><a href="?songId=<?php echo $songId ?>"><?php echo $songTitle ?></a></li>
        </ol>
    </nav>
</header>
<main>
    <section id="song-info">
        <div id="img-container">
            <img src="data:image/jpeg;base64,<?php echo $songCoverImageBase64 ?>" alt="<?php echo $songTitle ?> by <?php echo $artistName ?>"/>
        </div>
        <div id="about">
            <h1><?php echo $songTitle ?></h1>
            <h2><?php echo $artistName ?></h2>
            <p><?php echo $songDescription ?></p>
        </div>
    </section>
    <section id="lyrics">
        <h1>Lyrics</h1>
        <?php echo $songLyrics ?>
    </section>
    <section id="annotation">
    </section>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>
