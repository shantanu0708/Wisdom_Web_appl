<?php

$host = "localhost:3306";
$user = "root";
$password = "";
$dbname = "mentor";

$login_id = $_POST['login_id'];

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "SELECT batch_id FROM faculty_info WHERE login_id = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("s", $login_id);
$stmt1->execute();
$result1 = $stmt1->get_result();

$course_data = [];

if ($result1->num_rows > 0) {
    $row1 = $result1->fetch_assoc();
    $batch_id = $row1["batch_id"];

    $sql2 = "SELECT student_id FROM student_info WHERE batch_id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s", $batch_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $course_names = ['ads_db', 'cc_db', 'cc_lab_db', 'ds_db', 'mp_db', 'oe_db', 'online_intern_db', 'wt_db', 'wt_lab_db'];

    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $student_id = $row2["student_id"];

            foreach ($course_names as $course_name) {
                $sql3 = "SELECT course_code, Que_1, Que_2, Que_3, Que_4, Que_5 FROM $course_name WHERE student_id = ?";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param("s", $student_id);
                $stmt3->execute();
                $result3 = $stmt3->get_result();

                if ($result3->num_rows > 0) {
                    while ($row3 = $result3->fetch_assoc()) {
                        $course_code = $row3['course_code'];
                        $avg_rating = ($row3['Que_1'] + $row3['Que_2'] + $row3['Que_3'] + $row3['Que_4'] + $row3['Que_5']) / 5;
                        
                        // Append course data if course code already exists, otherwise create new entry
                        if (isset($course_data[$course_code])) {
                            $course_data[$course_code][] = $avg_rating;
                        } else {
                            $course_data[$course_code] = [$avg_rating];
                        }
                    }
                }
            }
        }
    }
}

$stmt1->close();
$stmt2->close();
$stmt3->close();
$conn->close();

// Calculate average ratings for each course
$subjects = [];
$ratings = [];
foreach ($course_data as $course_code => $ratings_array) {
    $subjects[] = $course_code;
    $ratings[] = array_sum($ratings_array) / count($ratings_array);
}

$data = array('subjects' => $subjects, 'rating' => $ratings);
echo json_encode($data);

?>
