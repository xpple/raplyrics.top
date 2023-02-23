<?php
use App\Models\AnnotationModel;
use App\Models\SongModel;
/* @var $song SongModel */
$song = $this->song;
/* @var $annotations AnnotationModel[] */
$annotations = $this->annotations;

/**
 * @param AnnotationModel[] $annotations
 */
function applyAnnotations(string $lyrics, array $annotations): string {
    $result = $lyrics;
    $offset = 0;
    $annotationType = $_GET["annotationType"] ?? "meaning";
    foreach ($annotations as $annotationEntry) {
        if ($annotationEntry->annotationType != $annotationType) {
            continue;
        }
        $annotationStart = $annotationEntry->annotationStart;
        $annotationLength = $annotationEntry->annotationLength;
        $annotation = htmlspecialchars($annotationEntry->annotation);
        $annotatedText = substr($result, $annotationStart + $offset, $annotationLength);
        $replacementString = <<<HTML
            <annotated-text>
                <mark slot="text">{$annotatedText}</mark>
                <template>{$annotation}</template>
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
    <title><?= htmlspecialchars($song->artistName) ?> - <?= htmlspecialchars($song->songTitle) ?> | Rap Lyrics Top</title>

    <link rel="stylesheet" href="/assets/style/main.css">
    <link rel="stylesheet" href="/assets/style/header.css">
    <link rel="stylesheet" href="/assets/style/song/song-info.css">
    <link rel="stylesheet" href="/assets/style/song/lyrics.css">
    <script src="/assets/script/search.js" type="module" async></script>
    <script src="/assets/script/annotation.js" type="module" async></script>
</head>
<body>
<header>
    <nav aria-label="breadcrumbs">
        <ol>
            <li><a href="/">Home</a></li>
            <li><a href="/songs/">Songs</a></li>
            <li><a href="/artists/<?= htmlspecialchars($song->artistDirectory) ?>/"><?= htmlspecialchars($song->artistName) ?></a></li>
            <li><a href="/songs/<?= htmlspecialchars($song->artistDirectory) ?>/<?= htmlspecialchars($song->songDirectory) ?>/"><?= htmlspecialchars($song->songTitle) ?></a></li>
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
    <section id="song-info">
        <div id="img-container">
            <img src="data:image/jpeg;base64,<?= base64_encode($song->songCoverImage) ?>" alt="<?= htmlspecialchars($song->songTitle) ?> by <?= htmlspecialchars($song->artistName) ?>" width="300px" height="300px">
        </div>
        <div id="about">
            <h1><?= htmlspecialchars($song->songTitle) ?></h1>
            <h2><?= htmlspecialchars($song->artistName) ?></h2>
            <p><?= htmlspecialchars($song->songDescription) ?></p>
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
                    <div class="option{$class}">
                        <span>{$option}</span>
                    </div>
                    HTML);
                }
                ?>
            </div>
            <h1>Lyrics</h1>
            <?= formatLyrics(applyAnnotations(htmlspecialchars($song->songLyrics), $annotations)) ?>
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
