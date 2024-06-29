<?php
$host = "localhost:3306";
$username = "root";
$password = "";
$dbname = "mentor";

$conn = new mysqli($host, $username, $password, $dbname);

$sql = "SELECT batch_id, batch_name FROM batch";
$result = $conn->query($sql);

$batches = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $batches[] = $row;
    }
}

echo json_encode($batches);

$conn->close();
?>
