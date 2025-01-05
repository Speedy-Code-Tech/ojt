<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once('../../backend/db_connect.php');
    $id = $_SESSION['user_id'];

    $result = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 0");
    $student = 0;
    while($row = $result->fetch_assoc() ) {
        $student = $student+1;
    }

    $result = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 1 ");
    $step1 = 0;
    while($row = $result->fetch_assoc() ) {
        $step1 = $step1+1;
    }

    $result = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 2");
    $step2 = 0;
    while($row = $result->fetch_assoc() ) {
        $step2 = $step2+1;
    }

    $result = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 3");
    $step3 = 0;
    while($row = $result->fetch_assoc() ) {
        $step3 = $step3+1;
    }


?>