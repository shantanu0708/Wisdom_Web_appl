<?php
$host = "localhost:3306";
$username = "root";
$password = "";
$dbname = "mentor";

$conn = new mysqli($host, $username, $password, $dbname);

$sql = "SELECT l.loginId, l.username, l.password, f.batch_id, f.first_name, f.last_name, f.email_id, f.phone_no 
        FROM login as l JOIN faculty_info as f ON l.loginId = f.login_id";

$result = $conn->query($sql);

$students = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

echo json_encode($students);

$conn->close();
?>
