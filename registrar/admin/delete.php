<?php
 if(session_status()===PHP_SESSION_NONE) session_start();
require('../../backend/db_connect.php');

// Function to update user status
function updateUserStatus($id, $status, $conn) {
    try {
        $status1 = ($status === 'Deactivated') ? 'deactivated' : 'active';

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE user SET status = ? WHERE user_id = ?");
        $stmt->bind_param("si", $status1, $id);

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = "User status updated to $status successfully.";
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Failed to update user status.';
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}

// Validate inputs
if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];
    updateUserStatus($id, $status, $conn);
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid input.';
}

header("Location: view.php");
exit;
