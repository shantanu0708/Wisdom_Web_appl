<?php

$host = "localhost:3306";
$username = "root";
$password = "";
$database = "mentor";


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $batch_name = $_POST["batch_name"];

    $sql = "INSERT INTO batch (batch_name) VALUES (?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $batch_name);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }

    $stmt->close();
}

$conn->close();
?>
