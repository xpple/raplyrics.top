<?php
if (count(get_included_files()) == 1) {
    exit("Direct access not permitted.");
}
require_once("./login-data.php");


try {
    $conn = new PDO("mysql:host=$server;port=$port;dbname=$dbname;charset=UTF8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Server error");
}
