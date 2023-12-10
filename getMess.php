<?php
$startTime = date_create("")->format("Y-m-d H:i:s.u");

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "irc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$messages = [];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function prepMessage(&$message) {
    $userAttributes = json_decode($message["UserAttributes"], true);
    $message["Attributes"] = array();
    $message["Attributes"]["UserColor"] = $userAttributes["color"];
    return $message;
}
// Loop for 10 seconds
for ($i = 0; $i < 100; $i++) {
    // Retrieve data from the database
    $sql = "SELECT `messages`.`Id`, `Name`, `Message`,`AddDate`, `Attributes` as UserAttributes FROM messages INNER JOIN users ON `users`.`Id` = `userId` WHERE AddDate >= '$startTime'";
    $result = $conn->query($sql);

    // If data is found, echo it back to the client
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            prepMessage($row);
            array_push($messages, $row);

            // echo json_encode($row);
        }
        break;
    }

    // Sleep for 0.1 seconds
    usleep(100000);
}

// Close the connection
header('Content-Type: application/json');
echo json_encode($messages);

$minutes_to_add = 1;

$time = date_create("");
$time->sub(new DateInterval('PT' . $minutes_to_add . 'M'));

$stamp = $time->format("Y-m-d H:i:s.u");
$sql = "DELETE FROM messages WHERE AddDate <= '$stamp'";
$result = $conn->query($sql);

$conn->close();

?>