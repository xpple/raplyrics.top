<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once("./php/connect.php");


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
            switch($_GET["annotationType"] ?? null) {
                default:
                case "meaning":
                    echo <<<HTML
                        <div class="option active">
                            <span>meaning</span>
                        </div>
                        <div class="option">
                            <span>rhythm</span>
                        </div>
                        HTML;
                    break;
                case "rhythm":
                    echo <<<HTML
                        <div class="option">
                            <span>meaning</span>
                        </div>
                        <div class="option active">
                            <span>rhythm</span>
                        </div>
                        HTML;
                    break;
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
