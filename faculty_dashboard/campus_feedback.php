<?php

    $host = "localhost:3306";
    $user = "root";
    $password = "";
    $dbname = "mentor";

    $lid = $_POST['login_id']; 

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql1 = "SELECT batch_id FROM faculty_info WHERE login_Id = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $lid);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        $row1 = $result1->fetch_assoc();
        $bid = $row1["batch_id"];

        $sql2 = "SELECT student_id FROM student_info WHERE batch_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $bid);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows > 0) {
            $data = array();

            while ($row2 = $result2->fetch_assoc()) {
                $sid = $row2["student_id"];
                $sql3 = "SELECT student_info.first_name, student_feedback.cleanliness, student_feedback.bus_facility, 
                        student_feedback.teaching_staff, student_feedback.campus, student_feedback.other, student_feedback.rating
                        FROM student_feedback JOIN student_info ON student_feedback.student_id = student_info.student_id WHERE student_info.student_id = ?";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->bind_param("s", $sid);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();

                    if ($result3->num_rows > 0) {
                        while ($row3 = $result3->fetch_assoc()) {
                            $data[] = $row3;
                        }
                    }
            }
        }
    }

    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
    $conn->close();

    echo json_encode($data);
?>
