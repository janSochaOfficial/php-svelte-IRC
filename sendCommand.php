<?php
 header("Access-Control-Allow-Origin: *");

header('Content-Type: application/json');

function changeColor($color, $name) {
    include "consts.php";


    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "SELECT `Attributes` FROM users WHERE `name` = '$name'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    $attributes = json_decode($user["Attributes"]);
    $attributes->color = $color;
    $attributesStr = json_encode($attributes);

    $sql = "UPDATE users SET Attributes = '$attributesStr' WHERE `name` = '$name'";
    mysqli_query($conn, $sql);

    mysqli_close($conn);
}

function changeNick($nick, $name) {
    include "consts.php";


    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $sql = "UPDATE users SET `Name` = '$nick' WHERE `Name` = '$name'";
    mysqli_query($conn, $sql);

    mysqli_close($conn);
}

if(!isset($_POST["name"]) || !isset($_POST["command"])) {
    header("http_response_code", true, 423);
    die();
}
$response = array();
switch($_POST["command"]) {
    case "color":
        if (!isset($_POST["value"])) {
            header("http_response_code", true, 400);
            $response["Message"] = "no color selected";
            break;
        }
        changeColor($_POST["value"], $_POST["name"]);
        $response["Message"] = "color changed to ".$_POST["value"];

        break;
    case "nick":
        if (!isset($_POST["value"])) {
            header("http_response_code", true, 400);
            $response["Message"] = "no color selected";
            break;
        }
        changeNick($_POST["value"], $_POST["name"]);
        $response["Message"] = "nick changed to ".$_POST["value"];
        $response["newName"] = $_POST["value"];
        break;
    default:
        header("http_response_code", true, 400);
        $response["Message"] = "Invalid command";
    }
    echo json_encode($response);