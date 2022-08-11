<?php
extract(file("login_data.txt", FILE_IGNORE_NEW_LINES), EXTR_PREFIX_ALL, "loginData");
$server = $loginData_0;
$port = $loginData_1;
$user = $loginData_2;
$pass = $loginData_3;
$dbname = $loginData_4;

try {
    $conn = new PDO("mysql:host=$server;port=$port;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    die("Server error");
}

if (array_key_exists("artistId", $_GET)) {
    $artistId = $_GET["artistId"];
//    $statement = $conn->prepare("SELECT artist_name, artist_icon FROM artists WHERE artist_id = :artist_id");
//    $statement->execute(array("artist_id" => $artistId));
//    $statement->setFetchMode(PDO::FETCH_ASSOC);
//    $result = $statement->fetchAll()[0];
//    $artistName = $result["artist_name"];
//    $artistIcon = $result["artist_icon"];
//    echo $artistName;
//    echo '<img src="data:image/jpeg;base64,'.base64_encode($artistIcon).'"/>';
    $statement = $conn->prepare("SELECT HEX(artist_id), artist_name, artist_icon FROM artists");
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $result = $statement->fetchAll()[0];
    foreach ($result as $column => $value) {
        echo $column.": ".$value."\n";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rap Lyrics Top</title>
</head>
<body>
Content Coming Soon. As a preview, check out <a href="/eminem/good-guy/">Good Guy by Eminem</a>.
</body>
</html>
