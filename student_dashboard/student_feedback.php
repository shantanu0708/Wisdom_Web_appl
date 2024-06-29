<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $lid = $_POST['login_id_'];
    $clean = $_POST['cleanliness'];
    $bus = $_POST['Bus_facility'];
    $teach = $_POST['Teaching_staff'];
    $campus = $_POST['Campus_feed'];
    $other = $_POST['Other_feed'];
    $rating = $_POST['rating'];

    $host="localhost:3306";
    $user="root";
    $password="";
    $dbname="mentor";
    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql2 = "SELECT student_id FROM student_info WHERE login_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $lid);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows > 0) {
            $row = $result2->fetch_assoc();
            $sid = $row["student_id"];

            $sql = 'INSERT INTO student_feedback (loginid, student_id, cleanliness, bus_facility, teaching_staff, campus, other, rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("sissssss", $lid, $sid, $clean, $bus, $teach, $campus, $other, $rating);

            if($stmt->execute()) {
                echo "<script>
                        window.onload = function() {
                            window.alert('Submit successfully!!');
                            window.location.href = 'student_dashboard.html';
                        };
                    </script>";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
                echo "<script>
                        window.onload = function() {
                            window.alert('$message');
                            window.location.href = 'student_feedback1.html';
                        };
                    </script>";
            }
        }
    }
    $conn->close();
}
?>
