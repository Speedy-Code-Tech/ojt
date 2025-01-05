<?php
require('../../backend/db_connect.php');
session_start();
// Initialize response array
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $user_id = $_SESSION['user_id'];
    $step2_docs_link = mysqli_real_escape_string($conn, $_POST['step2_docs_link']);

    // Validate the G-Link (optional)
    if (filter_var($step2_docs_link, FILTER_VALIDATE_URL)) {
        // Update the database with the new G-Link
        $update_query = "UPDATE application_table SET step2_docs_link = '$step2_docs_link' WHERE user_id = '$user_id'";

        if (mysqli_query($conn, $update_query)) {
            // Success response
            $response['status'] = 'success';
            $response['message'] = 'G-Link folder updated successfully!';
        } else {
            // Error response
            $response['status'] = 'error';
            $response['message'] = 'Failed to update G-Link folder. Please try again.';
        }
    } else {
        // Invalid G-Link response
        $response['status'] = 'error';
        $response['message'] = 'Please provide a valid G-Link URL.';
    }
}

// Return the response as JSON
echo json_encode($response);
?>
