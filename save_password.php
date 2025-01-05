<?php
require_once("backend/db_connect.php");

if(session_status() == PHP_SESSION_NONE) session_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data from the AJAX request
$email = $_POST['email'];
$newPassword = $_POST['password'];

// Sanitize input
$email = $conn->real_escape_string($email);
$newPassword = $conn->real_escape_string($newPassword);

// Hash the new password using PASSWORD_BCRYPT
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Update the user's password in the database
$sql = "UPDATE user SET password = '$hashedPassword' WHERE email = '$email'";

if ($conn->query($sql) === TRUE) {
    echo "Password updated successfully!";
    $_SESSION['success'] = "Password sent to your email!";
} else {
    echo "Error updating password: " . $conn->error;
}

// Close the connection
$conn->close();
?>
