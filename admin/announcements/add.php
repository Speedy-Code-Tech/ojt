<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION["page"] = "announcements";

// Ensure no output before this point
require('../../backend/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $from_msg = 'admin'; // Example: Hardcoded sender (you can change this)

    // Insert query
    $sql = "INSERT INTO announcement (`message`, `from_msg`) VALUES ('$message', '$from_msg')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Announcement added successfully!';
        header('Location: view.php'); // Redirect to dashboard
        exit; // Stop script execution after redirect
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
        header('Location: view.php'); // Redirect to dashboard
        exit; // Stop script execution after redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Add Announcement</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Sidebar -->
    <?php include("../sidebar.php"); ?>
    
    <!-- Main Content -->
    <div class="dashboard">
        <h2>ADD NEW ANNOUNCEMENT</h2>
        <hr>
        <div class="container-fluid">
            <form action="#" method="post">
                <textarea name="message" class="form-control" rows='20'></textarea>
                <button class="btn btn-success mt-2 px-4" style="position:absolute; right: 30px;">
                    <i class="fa-solid fa-floppy-disk"></i> Save
                </button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
