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
$dept='';
// Check if there is a result
if ($user && mysqli_num_rows($user) > 0) {
    $data = mysqli_fetch_assoc($user);
} else {
    $data = null;
}
$dept = $data['department'];

$data = strtoupper(mysqli_real_escape_string($conn, $data['department']));

$tables = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 4 AND pi_dept = '$data'");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$advisers = $conn->query("SELECT * FROM user WHERE type = 'adviser' AND department = '$dept'");

?>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="#" class="active"><i class="fa-solid fa-paperclip"></i> Students Approval <span class="badge bg-danger">0</span></a>
        <a href="intern_history/view.php"><i class="fa-solid fa-users"></i> Managed Intern</a>
        <a href="history/view.php"><i class="fa-solid fa-users"></i> Awaiting Review</a>
        <a href="../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="dashboard">
        <h3>4TH STEP ASSIGN INTERNS TO ADVISER OF <?= $data ?></h3>
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
                while ($row = $tables->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= $row['pi_fname'] . ' ' . $row['pi_mname'] . ' ' . $row['pi_lname']; ?></td>
                        <td><span class="fw-bold text-success">Approved by Admin</span></td>
                        <td>
                            <button class="btn btn-primary btn-sm assign-btn" data-id="<?= $row['application_id']; ?>" data-name="<?= $row['pi_fname'] . ' ' . $row['pi_mname'] . ' ' . $row['pi_lname']; ?>">Assign</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Assign Adviser</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="assignForm" action="assign_adviser.php" method="POST">
                        <input type="hidden" name="application_id" id="applicationId">
                        <div class="mb-3">
                            <label for="studentName" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="studentName" name="student_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="adviser" class="form-label">Adviser</label>
                            <select class="form-select" id="adviser" name="adviser" required>
                                <option value="" selected disabled>Select an adviser</option>
                                <?php while($r = $advisers->fetch_assoc()){?>
                                    <option value="<?= $r['user_id']?>"><?= $r['fname']. ' '.$r['mname'][0].'. '.$r['lname']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="assignForm" class="btn btn-primary">Assign</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#announcement').DataTable();

            // Show modal on Assign button click
            $('.assign-btn').on('click', function() {
                const applicationId = $(this).data('id');
                const studentName = $(this).data('name');

                // Set modal input values
                $('#applicationId').val(applicationId);
                $('#studentName').val(studentName);

                // Show the modal
                $('#assignModal').modal('show');
            });
        });
    </script>
</body>

</html>
