<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>


</head>
<?php
if(session_status()===PHP_SESSION_NONE)session_start();
require_once("../backend/db_connect.php");
// Query to get the latest announcement from the database
$query = "SELECT * FROM announcement ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

// Check if there is a result
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the latest announcement
    $announcement = mysqli_fetch_assoc($result);
} else {
    // No announcements found
    $announcement = null;
}
$id = $_SESSION['user_id'];
$query = "SELECT * FROM application_table WHERE user_id = $id";
$result = mysqli_query($conn, $query);
$steps  = 0;
$status  = "";
if ($result && mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        $steps = $row['application_step'];
        $status = $row['application_status'];
    }
}
?>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="#" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="application/redirect.php"><i class="fa-solid fa-boxes-stacked"></i> Application Status</a>
        <a href="after/status.php" class="ms-3 <?= ($steps == 5 && $status == 'ACCEPTED') ? 'd-block' : 'd-none' ?> ps-0"><i class="fa-solid fa-boxes-stacked"></i> After OJT</a>

        <a href="../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">

        <div class="announcement">
            <h2>Announcements</h2>
            <div>
                <span class="fw-bold">Date Announced:</span> <?php echo date("F d, Y", strtotime($announcement['date_created'])); ?>
            </div>
            <p class="ps-5 pt-3"><?=$announcement['message'];?></p>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>