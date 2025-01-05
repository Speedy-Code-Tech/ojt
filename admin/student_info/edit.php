<?php
require('../../backend/db_connect.php');
 if(session_status()===PHP_SESSION_NONE) session_start();
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    // Update the application status
    $query = "UPDATE application_table SET application_status = '$status',application_step=2 WHERE application_id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Intern '.$status .' successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
    }
    header('Location: view.php'); // Redirect to view users page

}
?>
