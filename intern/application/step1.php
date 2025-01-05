<?php
require('../../backend/db_connect.php');
session_start();

// Check if the application ID is provided
if (isset($_GET['id'])&&isset($_GET['step'])) {
    $application_id = intval($_GET['id']); // Sanitize the input
    $step = intval($_GET['step']); // Sanitize the input

    // Update the application_status to 'PENDING'
    $query = "UPDATE application_table SET application_status = 'PENDING', application_step = $step WHERE application_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $application_id);

        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Application status updated.';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Failed to update the application status.';
        }

        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to prepare the statement.';
    }
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid application ID.';
}

// Redirect back to the dashboard or relevant page
header("Location: status.php");
exit();
