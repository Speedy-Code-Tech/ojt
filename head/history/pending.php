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
        $link2 = $row['step2_docs_link'];
        $link3 = $row['step3_docs_link'];
        $before =  $row['application_step'];
        $beforestatus =  $row['application_status'];
        $aftersteps =  $row['after_ojt_steps'];
        $afterstatus =  $row['after_ojt_status'];
        $afterlink1 =  $row['after_ojt_step1'];
        $afterlink2 =  $row['after_ojt_step2'];
        $afterlink3 =  $row['after_ojt_step3'];
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
    $tables = $conn->query("SELECT * FROM application_table WHERE application_status = 'PENDING' AND application_step = 1 AND pi_dept = '$dept'");

    $counts = 0;
    while ($row = mysqli_fetch_assoc($tables)) {
        $counts = $count + 1;
    }
    ?>
    <div class="sidebar">
        <h4 class="text-center py-3">OJT System</h4>
        <a href="../dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="../view.php"><i class="fa-solid fa-paperclip"></i> Before OJT Step 1 <span class="badge bg-danger"><?= $count ?></span></a>
        <a href="../intern_history/view.php"><i class="fa-solid fa-users"></i> Intern History</a>
        <a href="#" class="active"><i class="fa-solid fa-users"></i> View History</a>
        <a href="../../backend/logout.php" class="logout"><i class="fa-solid fa-right-to-bracket"></i> Log Out</a>

    </div>
    <!-- Main Content -->
    <div class="dashboard">
        <h2>STATUS OF INTERN</h2>
        <hr>
        <h2>SUBMITED FORM BEFORE OJT</h2>
        <div class="container-fluid ps-4">
            <?php if ($before >= 1) { ?>

                <h3 class="text-primary">APPLICATION FORM FOR STEP 1</h3>
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
                    <div class="container-fluid pt-4 d-flex gap-2 justify-content-end align-items center">
                        <button data-ids="<?= $myId; ?>" data-step="0" data-status="PENDING" data-type="before" data-csteps="1" class="reject btn px-5 btn-lg btn-danger">Reject Form</button>
                        <button data-ids="<?= $myId; ?>" data-step="1" data-status="PENDING" data-type="before" data-csteps="1" class="approve btn px-5 btn-lg btn-success">Verify Form</button>
                    </div>
                </div>
                <hr>
            <?php }
            if ($before >= 2) { ?>
                <h3 class="text-primary">SUBMITTED FORM STEP 2</h3>
                <div class="container-fluid ps-3" style="font-size:1.25em">G-Link <a href="<?= $link2 ?>" style="font-style: italic; font-weight:bold;" target="__blank">Click Here to View the Submitted Link</a>
                    <div class="container-fluid pt-4 d-flex gap-2 justify-content-end align-items center">
                        <button data-ids="<?= $myId; ?>" data-step="1" data-status="PENDING" data-type="before" data-csteps="2" class="reject btn px-5 btn-lg btn-danger">Reject Form</button>
                        <button data-ids="<?= $myId; ?>" data-step="2" data-status="PENDING" data-type="before" data-csteps="2" class="approve btn px-5 btn-lg btn-success ">Verify Form</button>
                    </div>
                </div>
                <hr>
            <?php } ?>
            <?php if ($before >= 3) { ?>

                <h3 class="text-primary">SUBMITTED FORM STEP 3</h3>
                <div class="container-fluid ps-3" style="font-size:1.25em">G-Link <a href="<?= $link3 ?>" style="font-style: italic; font-weight:bold;" target="__blank">Click Here to View the Submitted Link</a>
                    <div class="container-fluid pt-4 d-flex gap-2 justify-content-end align-items center">
                        <button data-ids="<?= $myId; ?>" data-step="2" data-status="PENDING" data-type="before" data-csteps="3" class="reject btn px-5 btn-lg btn-danger">Reject Form</button>
                        <button data-ids="<?= $myId; ?>" data-step="3" data-status="PENDING" data-type="before" data-csteps="3" class="approve btn px-5 btn-lg btn-success">Verify Form</button>
                    </div>
                </div>
                <hr>
            <?php } ?>
            <?php if ($before >= 4) { ?>


                <h3 class="text-primary">SUBMITTED FORM STEP 4</h3>
                <div class="container-fluid ps-3" style="font-size:1.25em">

                    <div class="container-fluid pt-4 d-flex gap-2 justify-content-end align-items center">
                        <button data-ids="<?= $myId; ?>" data-step="3" data-status="PENDING" data-type="before" data-csteps="4" class="reject btn px-5 btn-lg btn-danger">Reject Form</button>
                        <button data-ids="<?= $myId; ?>" data-step="4" data-status="PENDING" data-type="before" data-csteps="4" class="approve btn px-5 btn-lg btn-success">Verify Form</button>
                    </div>
                </div>
                <hr>
            <?php } ?>
            <?php if ($before >= 4 && $beforestatus == 'ACCEPTED') { ?>


                <h3 class="text-primary">SUBMITTED FORM STEP 5</h3>
                <div class="container-fluid ps-3" style="font-size:1.25em">
                    <div class="container-fluid pt-4 d-flex gap-2 justify-content-end align-items center">
                        <button data-ids="<?= $myId; ?>" data-step="4" data-status="PENDING" data-type="before" data-csteps="5" class="reject btn px-5 btn-lg btn-danger">Reject Form</button>
                        <button data-ids="<?= $myId; ?>" data-step="5" data-status="ACCEPTED" data-type="before" data-csteps="5" class="approve btn px-5 btn-lg btn-success">Verify Form</button>
                    </div>
                </div>
                <hr>
            <?php } ?>

        </div>
        <?php if ($aftersteps >= 3) { ?>
            <br><br><br><br><br>
            <h2>SUBMITED FORM AFTER OJT</h2>
            <br>
            <div class="container-fluid ps-4">
                <?php if ($aftersteps >= 3) { ?>

                    <h3 class="text-primary">SUBMITTED FORM FOR STEP 1</h3>
                    <div class="container-fluid ps-3" style="font-size:1.25em">G-Link <a href="<?= $afterlink1 ?>" style="font-style: italic; font-weight:bold;" target="__blank">Click Here to View the Submitted Link</a>
                        <div class="container-fluid pt-4 d-flex gap-2 justify-content-end align-items center">
                            <button data-ids="<?= $myId; ?>" data-step="2" data-status="PENDING" data-type="after" data-csteps="2" class="reject btn px-5 btn-lg btn-danger">Reject Form</button>
                            <button data-ids="<?= $myId; ?>" data-step="3" data-status="PENDING" data-type="after" data-csteps="2" class="approve btn px-5 btn-lg btn-success ">Verify Form</button>
                        </div>
                    </div>
                    <hr>
                <?php }
                if ($aftersteps >= 4) { ?>
                    <h3 class="text-primary">SUBMITTED FORM STEP 2</h3>
                    <div class="container-fluid ps-3" style="font-size:1.25em">G-Link <a href="<?= $afterlink2 ?>" style="font-style: italic; font-weight:bold;" target="__blank">Click Here to View the Submitted Link</a>
                        <div class="container-fluid pt-4 d-flex gap-2 justify-content-end align-items center">
                            <button data-ids="<?= $myId; ?>" data-step="3" data-status="PENDING" data-type="after" data-csteps="2" class="reject btn px-5 btn-lg btn-danger">Reject Form</button>
                            <button data-ids="<?= $myId; ?>" data-step="4" data-status="PENDING" data-type="after" data-csteps="2" class="approve btn px-5 btn-lg btn-success ">Verify Form</button>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <?php if ($aftersteps >= 4 && $afterstatus == 'ACCEPTED') { ?>

                    <h3 class="text-primary">SUBMITTED FORM STEP 3</h3>
                    <div class="container-fluid ps-3" style="font-size:1.25em">G-Link <a href="<?= $afterlink3 ?>" style="font-style: italic; font-weight:bold;" target="__blank">Click Here to View the Submitted Link</a>
                        <div class="container-fluid pt-4 d-flex gap-2 justify-content-end align-items center">
                            <button data-ids="<?= $myId; ?>" data-step="4" data-status="PENDING" data-type="after" data-csteps="3" class="reject btn px-5 btn-lg btn-danger">Reject Form</button>
                            <button data-ids="<?= $myId; ?>" data-step="4" data-status="PENDING" data-type="after" data-csteps="3" class="approve btn px-5 btn-lg btn-success">Verify Form</button>
                        </div>
                    </div>
                    <hr>
                <?php } ?>

            <?php } ?>

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
        $('.approve').on('click', function() {
            const announcementId = $(this).data('ids'); // Get the announcement ID from the button's data-id attribute
            const steps = $(this).data('step'); // Get the announcement ID from the button's data-id attribute
            const csteps = $(this).data('csteps'); // Get the announcement ID from the button's data-id attribute
            const status = $(this).data('status'); // Get the announcement ID from the button's data-id attribute
            const type = $(this).data('type'); // Get the announcement ID from the button's data-id attribute

            Swal.fire({
                title: `Are you sure you want to approve Step No. ${csteps}?`,
                text: "You won't be able to revert this!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, approved it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete.php with the announcement ID
                    window.location.href = `edit.php?id=${announcementId}&status=${status}&steps=${steps}&type=${type}`;
                }
            });
        })
        $('.reject').on('click', function() {
            const announcementId = $(this).data('ids'); // Get the announcement ID from the button's data-id attribute
            const steps = $(this).data('step'); // Get the announcement ID from the button's data-id attribute
            const status = $(this).data('status'); // Get the announcement ID from the button's data-id attribute
            const type = $(this).data('type'); // Get the announcement ID from the button's data-id attribute
            const csteps = $(this).data('csteps'); // Get the announcement ID from the button's data-id attribute

            Swal.fire({
                title: `Are you sure you want to reject Step No. ${csteps}?`,
                text: "You won't be able to revert this!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, approved it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete.php with the announcement ID
                    window.location.href = `edit.php?id=${announcementId}&status=${status}&steps=${steps}&type=${type}`;

                }
            });
        })
    </script>


</body>

</html>