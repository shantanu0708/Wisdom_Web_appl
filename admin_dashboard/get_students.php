<?php
$host = "localhost:3306";
$username = "root";
$password = "";
$dbname = "mentor";

$conn = new mysqli($host, $username, $password, $dbname);

$sql = "SELECT l.loginId, l.username, l.password, s.batch_id, s.first_name, s.last_name, s.email_id, s.phone_no 
        FROM login as l JOIN student_info as s ON l.loginId = s.login_id";

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
