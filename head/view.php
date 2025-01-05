<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<?php
require('../backend/db_connect.php');
session_start();
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
$id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE user_id = $id";
$user = mysqli_query($conn, $query);

// Check if there is a result
if ($user && mysqli_num_rows($user) > 0) {
    $data = mysqli_fetch_assoc($user)['program'];
} else {
    $data = null;
}
$data = mysqli_real_escape_string($conn, $data);

$tables = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 0 AND pi_course = '$data'");
$tables1 = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 0 AND pi_course = '$data'");
$count = 0;
while($r=$tables1->fetch_assoc() ) {
// echo $r['user_id'];
    $count = $count+1;
}

?>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="dashboard.php" ><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="#" class="active" ><i class="fa-solid fa-paperclip"></i> Before OJT Step 1 <span class="badge bg-danger">0</span></a>
        <a href="intern_history/view.php"><i class="fa-solid fa-users"></i> Intern History</a>
        <a href="history/view.php"><i class="fa-solid fa-users"></i> View History</a>
        <a href="../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">
        <h2>INTERN PERSONAL INFORMATION</h2>
        <hr>
        <table class="table table-hover table-striped" id="announcement">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $tables->fetch_assoc()) {
                ?>

                    <tr>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= $row['pi_fname'] . ' ' . $row['pi_mname'] . ' ' . $row['pi_lname']; ?></td>
                        <td><span class="fw-bold text-success">Approved by Admin</span></td>
                        <td>
                            <button class="btn btn-success btn-sm approve-btn" data-status = "PENDING" data-id="<?= $row['application_id']; ?>">Approve</button>
                            <button class="btn btn-danger btn-sm decline-btn"  data-status = "DECLINED" data-id="<?= $row['application_id']; ?>">Decline</button>
                        </td>

                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Initialize DataTable
        $(document).ready(function() {
            $('#announcement').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            // Attach click event to all delete buttons
            $('.delete-btn').on('click', function() {
                const announcementId = $(this).data('id'); // Get the announcement ID from the button's data-id attribute

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete.php with the announcement ID
                        window.location.href = `delete.php?id=${announcementId}`;
                    }
                });
            });
            // Approve button click handler
            $('.approve-btn').on('click', function() {
                const applicationId = $(this).data('id'); // Get the application ID
                const status = $(this).data('status'); // Get the application ID

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to approve this application.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Approve',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to update.php with the application ID
                        window.location.href = `update.php?id=${applicationId}&status=${status}`;
                    }
                });
            });

            $('.decline-btn').on('click', function() {
                const applicationId = $(this).data('id'); // Get the application ID

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to approve this application.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Approve',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to update.php with the application ID
                        window.location.href = `update.php?id=${applicationId}`;
                    }
                });
            });
        });
    </script>

</body>

</html>