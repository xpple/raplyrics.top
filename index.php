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
    echo "Connection failed: " . $e->getMessage();
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
