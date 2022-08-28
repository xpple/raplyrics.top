<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once($_SERVER['DOCUMENT_ROOT'] . "../private/connect.php");


if (isset($songId)) {
    $statement = $conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_lyrics, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE HEX(song_id) = :song_id");
    $statement->execute(array("song_id" => $songId));
} elseif(isset($artistDirectory) and isset($songDirectory)) {
    $statement = $conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_lyrics, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE artist_directory = :artist_directory AND song_directory = :song_directory");
    $statement->execute(array("artist_directory" => $artistDirectory, "song_directory" => $songDirectory));
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
$songTitle = htmlspecialchars($row["song_title"]);
$artistName = htmlspecialchars($row["artist_name"]);
$artistDirectory = htmlspecialchars($row["artist_directory"]);
$songCoverImageBase64 = base64_encode($row["song_cover_image"]);
$songDescription = htmlspecialchars($row["song_description"]);
$songLyrics = htmlspecialchars($row["song_lyrics"]);
$songDirectory = htmlspecialchars($row["song_directory"]);

$statement = $conn->prepare("SELECT annotation_start, annotation_length, annotation, annotation_type FROM annotations WHERE HEX(song_id) = :song_id ORDER BY annotation_start ASC");
$statement->execute(array("song_id" => $songId));
$statement->setFetchMode(PDO::FETCH_ASSOC);
$annotations = $statement->fetchAll();


function applyAnnotations(string $lyrics, array $annotations): string {
    $result = $lyrics;
    $offset = 0;
    $annotationType = $_GET["annotationType"] ?? "meaning";
    foreach ($annotations as $annotationEntry) {
        if ($annotationEntry["annotation_type"] != $annotationType) {
            continue;
        }
        $annotationStart = $annotationEntry["annotation_start"];
        $annotationLength = $annotationEntry["annotation_length"];
        $annotation = htmlspecialchars($annotationEntry["annotation"]);
        $annotatedText = substr($result, $annotationStart + $offset, $annotationLength);
        $replacementString = <<<HTML
            <annotated-text>
                <span slot="text">$annotatedText</span>
                <template>$annotation</template>
            </annotated-text>
            HTML;
        $result = substr_replace($result, $replacementString, $annotationStart + $offset, $annotationLength);
        $offset += strlen($replacementString) - strlen($annotatedText);
    }
    return $result;
}

function formatLyrics(string $lyrics): string {
    $result = "";
    preg_match_all("/(?'brackets'^\[([^\s:\]]+):?\s*([^]]+)?])[\s\n]+([\s\S]*?)(?=(?&brackets)|\z)/m", $lyrics, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        if (empty($match[3])) {
            $result .= "<h2>$match[2]</h2>";
        } else {
            $result .= "<h2>$match[2]: $match[3]</h2>";
        }
        $result .= "<p class=\"" . strtolower($match[2]) . "\">$match[4]</p>";
    }
    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $artistName ?> - <?= $songTitle ?> | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
    <link rel="stylesheet" href="/assets/style/header.css">
    <link rel="stylesheet" href="/assets/style/song/song-info.css">
    <link rel="stylesheet" href="/assets/style/song/lyrics.css">
    <script src="/assets/script/module.js" type="module" async></script>
</head>
<body>
<header>
    <nav aria-label="breadcrumbs">
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/songs/">Songs</a></li>
            <li><a href="/artists/<?= $artistDirectory ?>/"><?= $artistName ?></a></li>
            <li><a href="/songs/<?= $artistDirectory ?>/<?= $songDirectory ?>/"><?= $songTitle ?></a></li>
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
    <section id="song-info">
        <div id="img-container">
            <img src="data:image/jpeg;base64,<?= $songCoverImageBase64 ?>" alt="<?= $songTitle ?> by <?= $artistName ?>" width="300px" height="300px">
        </div>
        <div id="about">
            <h1><?= $songTitle ?></h1>
            <h2><?= $artistName ?></h2>
            <p><?= $songDescription ?></p>
        </div>
    </section>
    <section id="lyrics">
        <div id="content">
            <span>Annotations:</span>
            <noscript>Annotations require JavaScript to work.</noscript>
            <div id="option-container">
                <?php
                $options = array("meaning", "stylistic devices", "rhythm");
                foreach ($options as $option) {
                    $class = ($_GET["annotationType"] ?? "meaning") == $option ? " active" : "";
                    echo(<<<HTML
                    <div class="option$class">
                        <span>$option</span>
                    </div>
                    HTML);
                }
                ?>
            </div>
            <h1>Lyrics</h1>
            <?= formatLyrics(applyAnnotations($songLyrics, $annotations)) ?>
        </div>
        <div id="annotation"></div>
    </section>
    <section id="submissions">
    </section>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>