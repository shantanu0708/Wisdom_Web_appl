<?php
$host = "localhost:3306";
$user = "root";
$pass_word = "";
$dbname = "mentor";

$conn = new mysqli($host, $user, $pass_word, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $batch_id = $_POST['batch_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email_id = $_POST['email_id'];
    $phone_no = $_POST['phone_no'];

    // Insert into student_info table
    $sql1 = "INSERT INTO login (username, password, mode) 
                 VALUES ('$username', '$password', 's')";
    
    // Get the last inserted ID for student_info table
    if ($conn->query($sql1) === TRUE) {
        $login_id = $conn->insert_id;

        // Insert into login table
        $sql2 = "INSERT INTO student_info (login_id, batch_id, first_name, last_name, email_id, phone_no) 
             VALUES ('$login_id', '$batch_id', '$first_name', '$last_name', '$email_id', '$phone_no')";
        
        if ($conn->query($sql2) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}

$conn->close();
?>

