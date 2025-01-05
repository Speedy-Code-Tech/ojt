<?php
session_start();
require_once("../../backend/db_connect.php");

$id = $_SESSION['user_id'];
$query = "SELECT * FROM application_table WHERE user_id = $id";
$result = mysqli_query($conn,  $query);

// Check if there is a result
if ($result && mysqli_num_rows($result) > 0) {
    $application = mysqli_fetch_array($result);
    $step = $application["application_step"];

    $data = true;
} else {
    $data = false;
}

$result = $conn->query("SELECT * FROM department");
$results = $conn->query("SELECT * FROM programs");
$r = $conn->query('SELECT * FROM requirement');

// Assume $id is retrieved safely and sanitized
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $id); // 'i' indicates an integer type
$stmt->execute();
$result1 = $stmt->get_result();

if ($result1->num_rows > 0) {
    $email = $result1->fetch_assoc(); // Fetch the user data as an associative array
    // Access the email, for example:
    // echo $email['email']; // Assuming the email column exists
} else {
    echo "No user found with the given ID.";
}

// Display success or error messages using SweetAlert
if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    $message = $_SESSION['message'];

    echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '$status',
                    title: '$message',
                    confirmButtonText: 'OK'
                });
            });
        </script>";
    unset($_SESSION['status']);
    unset($_SESSION['message']);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $link = mysqli_real_escape_string($conn, $_POST['link']); // Get the submitted G-Drive link

    // Update the application table with the G-Drive link and move to the next step
    $updateQuery = "UPDATE application_table SET after_ojt_step1 = ?,after_ojt_status='PENDING', after_ojt_steps = 2 WHERE user_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $link, $id); // 's' for string, 'i' for integer
    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'G-Drive link updated successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to update the G-Drive link. Please try again.';
    }
    header('Location: status.php'); // Redirect to refresh the page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Intern Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="../../assets/css/form.css">
    <link rel="stylesheet" href="../../assets/css/status.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="../dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="#"><i class="fa-solid fa-boxes-stacked"></i> Application Status</a>
        <a href=""class="ms-3 active ps-0"><i class="fa-solid fa-boxes-stacked"></i> After OJT</a>

        <a href="../../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">
        <div class="container-fluid">
            <h3 class="text-center pt-5">Step 1 - Submit the G-Drive Folder link of the following documents below.</h3>
            <div class="container-fluid d-flex flex-column">
                <ol class="d-flex flex-column gap-3 pt-5">
                    <li class=" h5">Practicum Evaluation</li>
                    <li class=" h5">Daily Time Record (DTR)</li>
                    <li class=" h5">Certificate of Completion</li>
                    <li class=" h5">Practicum Summary Report</li>
                </ol>
                <div class="container-fluid pt-4">
                    <!-- Form to submit the G-Drive link -->
                    <form method="POST" action="">
                        <label for="link" class="fw-bold pb-2">G Link for Containing the Document</label>
                        <input type="text" class="form-control py-3" id="link" required name="link" placeholder="https://drive.google.com/*****">
                        <div class="container-fluid text-end">
                            <button type="submit" class="btn btn-success px-5">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            var link = document.getElementById("link").value;
            var regex = /^https:\/\/drive\.google\.com\/.*$/;

            if (!regex.test(link)) {
                e.preventDefault(); // Prevent form submission
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Link',
                    text: 'Please enter a valid Google Drive link.'
                });
            }
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

</body>

</html>
