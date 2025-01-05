<?php
 if(session_status()===PHP_SESSION_NONE) session_start();
require('../../backend/db_connect.php');

// Function to delete an announcement
function deleteAnnouncement($id, $conn) {
    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("DELETE FROM programs WHERE id = ?");
        $stmt->bind_param("i", $id); // Bind the ID as an integer

        // Execute the query
        if ($stmt->execute()) {
            // Set success message in session
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Programs deleted successfully.';
        } else {
            // Set error message in session
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Failed to delete Programs.';
        }

        // Close the statement
        $stmt->close();
    } catch (Exception $e) {
        // Handle exceptions
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}

// Check if 'id' is passed in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Convert the ID to an integer
    deleteAnnouncement($id, $conn); // Call the function to delete the record
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid ID.';
}

// Redirect back to the announcements page
header("Location: view.php");
exit;
