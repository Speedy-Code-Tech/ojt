<?php
// Include database connection
$conn = include('./db_connect.php');

// Start a session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and password from POST
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password (assuming it's hashed in the database)
        if (password_verify($password, $user['password'])) {
            // Login successful, set session
            $_SESSION['user_id'] = $user['user_id'];
            $type = $user['type'];
            if($type == 'admin'){
                header('Location: ../admin/dashboard.php'); // Redirect to admin dashboard
            } else if($type == 'intern'){
                header('Location: ../intern/dashboard.php'); // Redirect to intern dashboard
            } else if($type == 'heads'){
                header('Location: ../head/dashboard.php'); // Redirect to head dashboard
            } else if($type == 'dean'){
                header('Location: ../dean/dashboard.php'); // Redirect to dean dashboard
            } else if($type == 'registrar'){
                header('Location: ../registrar/dashboard.php'); // Redirect to registrar dashboard
            } else if($type == 'adviser'){
                header('Location: ../adviser/dashboard.php'); // Redirect to adviser dashboard
            }
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid password.";
            header('Location: ../index.php'); // Redirect back to login page
            exit();
        }
    } else {
        // User not found
        $_SESSION['login_error'] = "User not found.";
        header('Location: ../index.php'); // Redirect back to login page
        exit();
    }
} else {
    $_SESSION['login_error'] = "Invalid request method.";
    header('Location: ../index.php'); // Redirect back to login page
    exit();
}
