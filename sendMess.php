<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "irc";

header('Content-Type: application/json');

if (!isset($_POST["name"]) or !isset($_POST["message"]) or trim($_POST["message"]) == "") {
    header("http_response_code", true, 400);
    die();
}

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    header("http_response_code", true, 500);
    die("Connection failed: " . $conn->connect_error);
}
try {
    $sql = "INSERT INTO `messages`( `UserId`, `Message`) VALUES ((SELECT Id FROM `users` where `Name` = '" . $_POST["name"] . "'),'" . trim($_POST["message"]) . "')";
    $result = $conn->query($sql);
} catch (mysqli_sql_exception) {
    header("http_response_code", true, 500);
}

$conn->close();