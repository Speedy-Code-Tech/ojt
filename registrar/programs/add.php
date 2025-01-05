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
<?php
 if(session_status()===PHP_SESSION_NONE) session_start();
require('../../backend/db_connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programs = mysqli_real_escape_string($conn, $_POST['programs']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    // Insert query
    $sql = "INSERT INTO programs (`programs`,`department`) VALUES ('$programs','$department')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Programs added successfully!';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Error: ' . mysqli_error($conn);
    }
    header('Location: view.php'); // Redirect to dashboard

}
$result = $conn->query("SELECT * FROM department");

?>

<body>
    <!-- Sidebar -->
    <?php
    $_SESSION["page"] = "programs";
    include("../sidebar.php");
    ?>

    <!-- Main Content -->
    <div class="dashboard">
        <h2>ADD NEW PROGRAMS</h2>
        <hr>
        <div class="container-fluid">
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" class="form-select" id="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['dept']) . '">' . htmlspecialchars($row['dept']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="programs" class="form-label">Programs Name</label>
                    <input type="text" name="programs" id="programs" placeholder="Programs" class="form-control">
                </div>
                <button class="btn btn-success mt-2 px-4" style="position:absolute; right: 30px;"><i class="fa-solid fa-floppy-disk"></i> Save</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>