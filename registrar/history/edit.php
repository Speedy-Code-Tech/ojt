<?php
require('../../backend/db_connect.php');
 if(session_status()===PHP_SESSION_NONE) session_start();
if (isset($_GET['id']) && isset($_GET['status'])&& isset($_GET['steps'])&& isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];
    $step = intval($_GET['steps']);
    $type = $_GET['type'];

    if($type=='before'){
        // Update the application status
    $query = "UPDATE application_table SET application_status = '$status',application_step=$step WHERE application_id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Application updated successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
    }
    header("Location: pending.php?id=$id"); // Redirect to view users page

    }else if($type=='after'){
        // Update the application status
    $query = "UPDATE application_table SET after_ojt_status = '$status',after_ojt_steps=$step WHERE application_id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Application updated successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
    }
    header("Location: pending.php?id=$id"); // Redirect to view users page

    }
    
}
?>
