<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJT System - Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/6226269109.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<?php
require('../../backend/db_connect.php');
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
$result1 = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 0");

?>

<body>
    <!-- Sidebar -->
    <?php
    $_SESSION["page"]="student_info";
        include("../sidebar.php") ;
    ?>

    <!-- Main Content -->
    <div class="dashboard">
        <h2>INTERN PERSONAL INFORMATION</h2>
        <hr>
        <table class="table table-hover table-striped" id="announcement">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Program</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result1->fetch_assoc()) {
                ?>

                    <tr>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= $row['pi_fname'] . ' ' . $row['pi_mname'] . ' ' . $row['pi_lname']; ?></td>
                        <td><?= $row['pi_dept']; ?></td>
                        <td><?= $row['pi_course']; ?></td>
                        <td><?= $row['application_status']; ?></td>
                        <td>
                            <a href="info.php?id=<?= $row['application_id']; ?>" class="btn btn-success btn-sm">View Details</a>
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
        });
    </script>

</body>

</html>