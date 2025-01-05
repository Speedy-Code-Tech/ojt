<?php
 if(session_status()===PHP_SESSION_NONE) session_start();
require('../../backend/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csvFile'])) {
    $file = $_FILES['csvFile'];

    // Check if the file is a CSV
    if ($file['type'] !== 'text/csv') {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Please upload a valid CSV file.';
        header('Location: add_bulk_interns.php');
        exit;
    }

    // Read the CSV file
    $handle = fopen($file['tmp_name'], 'r');
    $lineNumber = 0;
    $insertedCount = 0;

    // Start a transaction for bulk insert
    mysqli_begin_transaction($conn);

    try {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $lineNumber++;

            // Skip the header line
            if ($lineNumber == 1) continue;

            // Assuming the CSV has email and password columns
            $email = mysqli_real_escape_string($conn, $data[0]);
            $password = mysqli_real_escape_string($conn, $data[1]);
            $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password
            $type = 'intern'; // Default user type

            // Insert query
            $sql = "INSERT INTO user (email, password, type) VALUES ('$email', '$hashed_password', '$type')";
            if (mysqli_query($conn, $sql)) {
                $insertedCount++;
            } else {
                throw new Exception('Error inserting user: ' . mysqli_error($conn));
            }
        }

        // Commit transaction
        mysqli_commit($conn);

        $_SESSION['status'] = 'success';
        $_SESSION['message'] = "$insertedCount Interns added successfully!";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        mysqli_rollback($conn);
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }

    fclose($handle);
    header('Location: view.php');
    exit;
}
?>
