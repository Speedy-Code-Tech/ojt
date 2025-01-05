<?php
session_start();

// Unset the session variables
unset($_SESSION['msg']);
unset($_SESSION['user_email']);

// Optionally destroy the session if no longer needed
// session_destroy();

// Redirect back to the desired page
header("Location: students.php"); // Replace with your desired redirect page
exit();
