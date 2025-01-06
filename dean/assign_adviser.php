<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../backend/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data from the modal
    $applicationId = mysqli_real_escape_string($conn, $_POST['application_id']);
    $studentName = mysqli_real_escape_string($conn, $_POST['student_name']);
    $adviserEmail = mysqli_real_escape_string($conn, $_POST['adviser']);

    // Validate input
    if (empty($applicationId) || empty($adviserEmail)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Application ID and Adviser are required.';
        header('Location: dashboard.php');
        exit;
    }

    // Assign adviser to the application
    $updateQuery = "UPDATE application_table SET adviser = '$adviserEmail',application_step=5 WHERE application_id = '$applicationId'";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Adviser successfully assigned to the student!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to assign adviser. Error: ' . mysqli_error($conn);
    }

    // Redirect back to the dashboard
    header('Location: students.php');
    exit;
} else {
    // If accessed without POST data, redirect to the dashboard
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid request.';
    header('Location: students.php');
    exit;
}
?>
