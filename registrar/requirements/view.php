<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require('../../backend/db_connect.php');

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
?>
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

<body>
    <!-- Sidebar -->
    <?php
    $_SESSION["page"] = "requirements";
    include("../sidebar.php");
    ?>

    <!-- Main Content -->
    <div class="dashboard">
        <h2>REQUIREMENTS</h2>
        <a href="add.php" class="btn btn-success" style="position: absolute; right: 30px; top: 20px;"><i class="fa-solid fa-plus"></i> Add New</a>
        <hr>
        <table class="table table-hover table-striped" id="announcement">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Requirement Name</th>
                    <th>Year Created</th>
                </tr>
            </thead>
            <tbody>
                <!-- The table will be dynamically filled via DataTables -->
            </tbody>
        </table>
    </div>

    <!-- DataTables and Bootstrap JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable with server-side processing
            $('#announcement').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'fetch_requirements.php', // Server-side script
                    type: 'GET',
                    dataSrc: function(json) {
                        console.log('Server response:', json); // Log the entire response
                        return json.data; // Pass the data property to DataTables
                    },
                    error: function(xhr, error, thrown) {
                        console.error('Error in DataTables AJAX:', xhr.responseText); // Log errors
                    }
                },
                columns: [{
                        data: 0,
                        title: "No."
                    }, // ID or number
                    {
                        data: 1,
                        title: "Requirement Name"
                    }, // Name,
                    {
                        data: 2,
                        title: "Year Created"
                    } // Name
                ]
            });

        });

        // Delete confirmation
        $(document).on('click', '.delete-btn', function() {
            const announcementId = $(this).data('id');

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
                    window.location.href = `delete.php?id=${announcementId}`;
                }
            });
        });
    </script>
</body>

</html>