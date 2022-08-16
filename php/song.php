<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once($_SERVER['DOCUMENT_ROOT'] . "/php/connect.php");


if ($songId) {
    $statement = $conn->prepare("SELECT HEX(song_id) as song_id, song_title, HEX(songs.artist_id) as artist_id, artist_name, artist_directory, song_cover_image, song_description, song_lyrics, song_directory FROM songs JOIN artists on songs.artist_id = artists.artist_id WHERE HEX(song_id) = :song_id");
    $statement->execute(array("song_id" => $songId));
} elseif($artistDirectory and $songDirectory) {
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
$songId = $row["song_id"];
$songTitle = $row["song_title"];
$artistId = $row["artist_id"];
$artistName = $row["artist_name"];
$artistDirectory = $row["artist_directory"];
$songCoverImage = $row["song_cover_image"];
$songCoverImageBase64 = base64_encode($songCoverImage);
$songDescription = $row["song_description"];
$songLyrics = $row["song_lyrics"];
$songDirectory = $row["song_directory"];

$statement = $conn->prepare("SELECT annotation_start, annotation_length, annotation, annotation_type FROM annotations WHERE HEX(song_id) = :song_id ORDER BY annotation_start ASC");
$statement->execute(array("song_id" => $songId));
$statement->setFetchMode(PDO::FETCH_ASSOC);
$annotations = $statement->fetchAll();


function applyAnnotations(string $lyrics, array $annotations): string {
    $result = $lyrics;
    $offset = 0;
    if (array_key_exists("annotationType", $_GET)) {
        $annotationType = $_GET["annotationType"];
    } else {
        $annotationType = "meaning";
    }
    foreach ($annotations as $annotationEntry) {
        if ($annotationEntry["annotation_type"] != $annotationType) {
            continue;
        }
        $annotationStart = $annotationEntry["annotation_start"];
        $annotationLength = $annotationEntry["annotation_length"];
        $annotation = $annotationEntry["annotation"];
        $annotatedText = substr($result, $annotationStart + $offset, $annotationLength + $offset);
        $replacementString = <<<HTML
            <annotated-text>
                <span slot="text">$annotatedText</span>
                <template>$annotation</template>
            </annotated-text>
            HTML;
        $result = substr_replace($result, $replacementString, $annotationStart + $offset, $annotationLength + $offset);
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
    <title><?php echo $artistName ?> - <?php echo $songTitle ?> | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
    <link rel="stylesheet" href="/assets/style/lyrics.css">
    <script src="/assets/script/module.js" type="module" async></script>
</head>
<body>
<header>
    <nav>
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/artists/<?php echo $artistDirectory ?>/"><?php echo $artistName ?></a></li>
            <li><a href="/songs/<?php echo $artistDirectory ?>/<?php echo $songDirectory ?>/"><?php echo $songTitle ?></a></li>
        </ol>
    </nav>
</header>
<main>
    <section id="song-info">
        <div id="img-container">
            <img src="data:image/jpeg;base64,<?php echo $songCoverImageBase64 ?>" alt="<?php echo $songTitle ?> by <?php echo $artistName ?>" width="300px" height="300px">
        </div>
        <div id="about">
            <h1><?php echo $songTitle ?></h1>
            <h2><?php echo $artistName ?></h2>
            <p><?php echo $songDescription ?></p>
        </div>
    </section>
    <section id="lyrics">
        <span>Annotations:</span>
        <div id="option-container">
            <?php
            $options = array("meaning", "stylistic devices", "rhythm");
            foreach ($options as $option) {
                $class = $_GET["annotationType"] ?? "meaning" == $option ? " active" : "";
                echo(<<<HTML
                    <div class="option$class">
                        <span>$option</span>
                    </div>
                    HTML);
            }
            ?>
        </div>
        <h1>Lyrics</h1>
        <?php
        echo formatLyrics(applyAnnotations($songLyrics, $annotations));
        ?>
    </section>
    <section id="annotation">
    </section>
</main>
<footer>
    [Footer]
</footer>
</body>
</html>
