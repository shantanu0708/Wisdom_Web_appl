<?php

    $host="localhost:3306";
    $user="root";
    $password="";
    $dbname="mentor";

    $conn = new mysqli($host, $user, $password, $dbname);
    $u_name = $_POST['faculty-username'];
    $p_word = $_POST['faculty-password'];
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }else {
        $sql = "SELECT * FROM login WHERE username='$u_name' AND password='$p_word' AND mode='f'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = $row["loginId"];
            echo "<script>
                        window.onload = function() {
                            window.alert('Login successfully!!');
                            localStorage.setItem('login_id','$data');
                            window.location.href = 'faculty_dashboard.html';
                        };
                </script>"; 
        } else {
            echo "<script>
                        window.onload = function() {
                            window.alert('Invalid username or password!!');
                            window.location.href = 'http://localhost/mentor/login.html';
                        };
                </script>";
        }
    }

    $conn->close();
?>
