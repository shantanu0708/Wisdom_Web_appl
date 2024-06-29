<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $lid = $_POST['login_id_'];
    $Q1 = $_POST['q1'];
    $Q2 = $_POST['q2'];
    $Q3 = $_POST['q3'];
    $Q4 = $_POST['q4'];
    $Q5 = $_POST['q5'];

    $host="localhost:3306";
    $user="root";
    $password="";
    $dbname="mentor";
    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

        $sql1 = "SELECT student_id FROM student_info WHERE login_id = '$lid'"; 
        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sid = $row["student_id"];

            $sql = 'INSERT INTO wt_lab_db (student_id, Que_1, Que_2, Que_3, Que_4, Que_5) VALUES (?, ?, ?, ?, ?, ?)';
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("siiiii", $sid, $Q1, $Q2, $Q3, $Q4, $Q5);

            if($stmt->execute()) {
                echo "<script>
                        window.onload = function() {
                            window.alert('Submit successfully!!');
                            window.location.href = 'subjectwise_feedback.html';
                        };
                    </script>";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
                echo "<script>
                        window.onload = function() {
                            window.alert('$message');
                            window.location.href = 'WT_lab_form.html';
                        };
                    </script>";
            }
        }
    $conn->close();
}
?>
