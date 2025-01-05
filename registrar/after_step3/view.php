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
if (session_status() === PHP_SESSION_NONE) session_start();
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
$result2 = $conn->query("SELECT * FROM application_table WHERE after_ojt_status = 'PENDING' AND after_ojt_steps = 4");
?>

<body>
    <!-- Sidebar -->
    <?php
    $_SESSION["page"] = "afterstep3";
    include("../sidebar.php");
    ?>
    <!-- Main Content -->
    <div class="dashboard">
        <h2>3RD STEP PENDING AFTER OJT</h2>
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
                while ($row = $result2->fetch_assoc()) {
                ?>

                    <tr>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= $row['pi_fname'] . ' ' . $row['pi_mname'] . ' ' . $row['pi_lname']; ?></td>
                        <td><?= $row['pi_dept']; ?></td>
                        <td><?= $row['pi_course']; ?></td>
                        <td><?= $row['after_ojt_status']; ?></td>
                        <td>
                            <div class="container-fluid d-flex gap-2 justify-content-center align-items center">
                                <!-- <button id="reject" data-id="<?= $row['application_id']; ?>" class="btn  btn-danger">Decline</button> -->
                                <button  data-id="<?= $row['application_id']; ?>" class="btn btn-success approve">Approve</button>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
        <?php
        if (isset($_SESSION['msg']) && isset($_SESSION['user_email'])) {
            $emails = $_SESSION['user_email'];
            $message = $_SESSION['msg'];
        } else {
            $emails = "";
            $message = "";
        }

        ?>
        <input name="" type="hidden" id="msg" value="<?= $message ?>">
        <input type="hidden" value="<?= $emails ?>" id="ems">
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <?php
    if (isset($_SESSION['msg']) && isset($_SESSION['user_email'])) {

    ?>

        <script>
            // EmailJS initialization
            (function() {
                emailjs.init({
                    publicKey: "S1FtNxV2rLYANKTgj", // Your public key
                });
            })();
            window.onload = function() {
                const email = document.getElementById("ems").value;
                const msg = document.getElementById("msg").value;
                // Prepare parameters for EmailJS
                let params = {
                    from_name: "TECHNICAL OF LA SALLE UNIVERSITY", // Your email address
                    to_name: email, // User's email
                    message: msg,
                };

                // Send the email
                emailjs.send('service_e5jiq55', 'template_4nyg8cf', params).then((result) => {
                    window.location.href = "session.php";

                }).catch((err) => {
                    console.log(err);
                    window.location.href = "session.php";

                    // Swal.fire('Error', 'Failed to send email. Please try again.', 'error');
                });
            }
        </script>
    <?php } ?>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
       <script>
        $('.approve').on('click', function() {
            const announcementId = $(this).data('id'); // Get the announcement ID from the button's data-id attribute
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, approved it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete.php with the announcement ID
                    window.location.href = `edit.php?id=${announcementId}&status=ACCEPTED`;
                }
            });
        })
        $('#reject').on('click', function() {
            const announcementId = $(this).data('id'); // Get the announcement ID from the button's data-id attribute

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, approved it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete.php with the announcement ID
                    window.location.href = `edit.php?id=${announcementId}&status=REJECTED`;
                }
            });
        })
    </script>

</body>

</html>