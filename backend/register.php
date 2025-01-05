<?php
session_start();
require_once("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $department = trim($_POST['department']);
    $program = trim($_POST['program']);

    // Error collection
    $errors = [];

    // Validation: Check if email ends with @lsu.edu.ph
    if (!$email || !preg_match("/@lsu\.edu\.ph$/", $email)) {
        $errors['email'] = "Email must end with @lsu.edu.ph.";
    }

    // Check if passwords match
    if ($password !== $confirmpassword) {
        $errors['password'] = "Passwords do not match.";
    }

    // Check if department and program are selected
    if (empty($department)) {
        $errors['department'] = "Please select a department.";
    }
    if (empty($program)) {
        $errors['program'] = "Please select a program.";
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT user_id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors['email'] = "Email is already registered.";
    }

    // If there are errors, redirect back with session data
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST; // Preserve old input
        header("Location: ../register.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO user (email, password,type, department, program) VALUES (?, ?, 'intern',?, ?)");
    $stmt->bind_param("ssss", $email, $hashed_password, $department, $program);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! You can now log in.";
        header(header: "Location: ../index.php");
        exit();
    } else {
        $_SESSION['error'] = "An error occurred. Please try again.";
        header("Location: ../register.php");
        exit();
    }

    $stmt->close();
}
?>
