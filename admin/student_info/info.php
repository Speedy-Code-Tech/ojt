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
    <style>
        .infos {
            border: none;
            border-bottom: 1px solid #918C8C;
            width: 100%;
            padding: 10px 15px;
            font-size: 1.25em;
        }

        #label>div>label {
            font-weight: bold;
        }
    </style>
</head>
<?php
require('../../backend/db_connect.php');
require('badge.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "SELECT * FROM application_table WHERE application_id = $id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fname = $row['pi_fname'];
        $mname = $row['pi_mname'];
        $lname = $row['pi_lname'];
        $dept = $row['pi_dept'];
        $program = $row['pi_course'];
        $level = $row['pi_year_lv'];
        $gender = $row['pi_gender'];
        $age = $row['pi_age'];
        $status = $row['pi_civil_status'];
        $birth = $row['pi_bdate'];
        $contact = $row['pi_contact'];
        $email = $row['pi_email'];
        $address = $row['pi_address'];
        $start_year = $row['start_date'];
        $end_year = $row['end_date'];
        $training = $row['ptd_establishment'];
        $training_address = $row['ptd_address'];
        $contact_num = $row['ptd_contact_number'];
        $duration = $row['ptd_training_hrs'];
        $start_date = $row['ptd_start_date'];
        $start_end = $row['ptd_end_date'];
        $fullname = $row['cdi_name'];
        $relationship = $row['cdi_relationship'];
        $contacts = $row['cdi_contact'];
        $home_address = $row['cdi_address'];
        $company = $row['cdi_com_address'];
        $myId = $row['application_id'];
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "ID not found in URL.";
}
?>

<body>
    <!-- Sidebar -->
    <?php
    $_SESSION["page"] = "student_info";
    include("../sidebar.php");
    ?>
    <!-- Main Content -->
    <div class="dashboard">
        <h2>INTERN PERSONAL INFORMATION</h2>
        <hr>
        <div class="container mt-5">
            <h2 class="section-title pb-3">Personal Info</h2>
            <div class="row">
                <div class="col-md-6 d-flex flex-column gap-4" id="label">
                    <div>
                        <label for="fname">First Name:</label>
                        <input type="text" name="fname" id="fname" value="<?= $fname; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Last Name:</label>
                        <input type="text" name="fname" id="fname" value="<?= $lname; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Program:</label>
                        <input type="text" name="fname" id="fname" value="<?= $program; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Gender:</label>
                        <input type="text" name="fname" id="fname" value="<?= $gender; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Civil Status:</label>
                        <input type="text" name="fname" id="fname" value="<?= $status; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Contact Number:</label>
                        <input type="text" name="fname" id="fname" value="<?= $contact; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Home Address:</label>
                        <input type="text" name="fname" id="fname" value="<?= $address; ?>" readonly class="infos">
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column gap-4" id="label">
                    <div>
                        <label for="fname">Middle Name:</label>
                        <input type="text" name="fname" id="fname" value="<?= $mname; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Department:</label>
                        <input type="text" name="fname" id="fname" value="<?= $dept; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Year Level:</label>
                        <input type="text" name="fname" id="fname" value="<?= $level; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Age:</label>
                        <input type="text" name="fname" id="fname" value="<?= $age; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Birth Date:</label>
                        <input type="text" name="fname" id="fname" value="<?= $birth; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Email Address:</label>
                        <input type="text" name="fname" id="fname" value="<?= $email; ?>" readonly class="infos">
                    </div>
                </div>
            </div>
            <h2 class="section-title pb-3 pt-5">School Year</h2>
            <div class="row">
                <div class="col-md-6 d-flex flex-column gap-4" id="label">
                    <div>
                        <label for="fname">Start Year:</label>
                        <input type="text" name="fname" id="fname" value="<?= $start_year; ?>" readonly class="infos">
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column gap-4" id="label">
                    <div>
                        <label for="fname">End Year:</label>
                        <input type="text" name="fname" id="fname" value="<?= $end_year; ?>" readonly class="infos">
                    </div>
                </div>
            </div>

            <h2 class="section-title pb-3 pt-5">Practicum Training Details</h2>
            <div class="row">
                <div class="col-md-6 d-flex flex-column gap-4" id="label">
                    <div>
                        <label for="fname">Training Establishment:</label>
                        <input type="text" name="fname" id="fname" value="<?= $training; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Contact Number:</label>
                        <input type="text" name="fname" id="fname" value="<?= $contact_num; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Start Date:</label>
                        <input type="text" name="fname" id="fname" value="<?= $start_date; ?>" readonly class="infos">
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column gap-4" id="label">
                    <div>
                        <label for="fname">Address:</label>
                        <input type="text" name="fname" id="fname" value="<?= $training_address; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Duration of Training Hours:</label>
                        <input type="text" name="fname" id="fname" value="<?= $duration; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">End Date:</label>
                        <input type="text" name="fname" id="fname" value="<?= $start_end; ?>" readonly class="infos">
                    </div>
                </div>
            </div>
            <h2 class="section-title pb-3 pt-5">Contact Details incase of Emergency</h2>
            <div class="row">
                <div class="col-md-6 d-flex flex-column gap-4" id="label">
                    <div>
                        <label for="fname">FullName:</label>
                        <input type="text" name="fname" id="fname" value="<?= $fullname; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Contact Number:</label>
                        <input type="text" name="fname" id="fname" value="<?= $contacts; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Company Address:</label>
                        <input type="text" name="fname" id="fname" value="<?= $company; ?>" readonly class="infos">
                    </div>

                </div>
                <div class="col-md-6 d-flex flex-column gap-4" id="label">
                    <div>
                        <label for="fname">Relationship:</label>
                        <input type="text" name="fname" id="fname" value="<?= $relationship; ?>" readonly class="infos">
                    </div>
                    <div>
                        <label for="fname">Home Address:</label>
                        <input type="text" name="fname" id="fname" value="<?= $home_address; ?>" readonly class="infos">
                    </div>
                </div>
            </div>
            <div class="container-fluid pt-4 d-flex gap-2 justify-content-center align-items center">
               
            <button id="reject" data-ids="<?= $myId; ?>" class="btn px-5 btn-lg btn-danger">Reject Form</button>
                <button id="approve" data-ids="<?= $myId; ?>" class="btn px-5 btn-lg btn-success">Verify Form</button>
            </div>
        </div>

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
        $('#approve').on('click', function() {
            const announcementId = $(this).data('ids'); // Get the announcement ID from the button's data-id attribute
            
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
                    window.location.href = `edit.php?id=${announcementId}&status=PENDING`;
                }
            });
        })
        $('#reject').on('click', function() {
            const announcementId = $(this).data('ids'); // Get the announcement ID from the button's data-id attribute

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