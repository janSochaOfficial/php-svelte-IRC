<?php
 header("Access-Control-Allow-Origin: *");
 include "consts.php";


header('Content-Type: application/json');

if (!isset($_POST["name"])) {
    header("http_response_code", true, 400);
    die();
}

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE `Name` = '" . $_POST["name"] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    die();
}

// insert new name into a database

$colors = [
    '#FF0000', // Red
    '#FFA500', // Orange 
    '#FFFF00', // Yellow
    '#00FF00', // Lime 
    '#00FFFF', // Cyan
    '#0000FF', // Blue
    '#9400D3', // Dark Violet
    '#4B0082', // Indigo
    '#9932CC', // Dark Orchid
    '#BA55D3', // Medium Orchid
    '#8A2BE2', // Blue Violet 
    '#A52A2A', // Brown
    '#DEB887', // Beige
    '#5F9EA0', // Cadet Blue
    '#7FFF00' // Chartreuse
];

$randomColor = $colors[array_rand($colors)];

$attributes = array();
$attributes["color"] = $randomColor;

$sql = "INSERT INTO users (`Name`, `Attributes`) VALUES ('" . $_POST["name"] . "', '" . json_encode($attributes) . "')";
$conn->query($sql);
$conn->close();
