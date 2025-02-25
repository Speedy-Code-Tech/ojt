<?php
require('../../backend/db_connect.php');
 if(session_status()===PHP_SESSION_NONE) session_start();

// Check if the application ID is provided
if (isset($_GET['id']) && isset($_GET['status'])) {
    $application_id = intval($_GET['id']); // Sanitize the input
    $status = $_GET['status']; // Sanitize the input

    // Update query to change the status to "APPROVED"
    $query = "UPDATE application_table SET application_status = '$status', application_step = 2 WHERE application_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $application_id);
        $s = strtolower($status);
        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Application '.$s.' successfully.';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Failed to '.$s.' the application.';
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

// Redirect back to the dashboard
header("Location: view.php");
exit();
