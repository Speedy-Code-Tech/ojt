<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    require_once($_SERVER['DOCUMENT_ROOT'] . '/backend/db_connect.php');
    $id = $_SESSION['user_id'];

    $result = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 1");
    $student = 0;
    
    if($result->num_rows > 0) {
    while($row = $result->fetch_assoc() ) {
       $student = $student+1;
    }
}

    $result12 = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 2 ");
    $step1 = 0;
    while($row = $result12->fetch_assoc() ) {
        $step1 = $step1+1;
    }

    $result = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 3");
    $step2 = 0;
    while($row = $result->fetch_assoc() ) {
        $step2 = $step2+1;
    }

    $result = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 4");
    $step3 = 0;
    while($row = $result->fetch_assoc() ) {
        $step3 = $step3+1;
    }

    $afterresult1 = $conn->query("SELECT * FROM application_table WHERE after_ojt_status = 'PENDING' AND after_ojt_steps = 2 ");
    $afterstep1 = 0;
    while($row = $afterresult1->fetch_assoc() ) {
        $afterstep1 = $afterstep1+1;
    }

    $afterresult2 = $conn->query("SELECT * FROM application_table WHERE after_ojt_status = 'PENDING' AND after_ojt_steps = 3");
    $afterstep2 = 0;
    while($row = $afterresult2->fetch_assoc() ) {
        $afterstep2 = $afterstep2+1;
    }

    $afterresult3 = $conn->query("SELECT * FROM application_table WHERE after_ojt_status = 'PENDING' AND after_ojt_steps = 4");
    $afterstep3 = 0;
    while($row = $afterresult3->fetch_assoc() ) {
        $afterstep3 = $afterstep3+1;
    }


?>